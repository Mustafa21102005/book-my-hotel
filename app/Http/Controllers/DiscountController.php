<?php

namespace App\Http\Controllers;

use App\Http\Requests\RedeemDiscountRequest;
use App\Models\Discount;
use App\Http\Requests\StoreDiscountRequest;
use App\Http\Requests\UpdateDiscountRequest;
use App\Models\Point;
use App\Models\RedeemedDiscount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class DiscountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $discounts = Discount::all();

        return view('discounts.index', compact('discounts'));
    }

    /**
     * This function is used to display all discounts for customers.
     *
     */
    public function customer()
    {
        $userId = auth()->id();

        $points = Point::where('user_id', $userId)->first();

        // Show only valid (not expired) discounts
        $discounts = Discount::where(function ($q) {
            $q->whereNull('expires_at')
                ->orWhere('expires_at', '>=', now());
        })->get();

        $redeemedDiscountIds = RedeemedDiscount::where('user_id', $userId)
            ->pluck('discount_id')
            ->toArray();

        return view('discounts.customer.index', compact('discounts', 'points', 'redeemedDiscountIds'));
    }

    /**
     * Show the list of redeemed discounts for the customer.
     *
     * @return \Illuminate\Http\Response
     */
    public function redeemedList()
    {
        $user = auth()->user();

        $redeemed = RedeemedDiscount::with('discount')
            ->where('user_id', $user->id)
            ->latest()
            ->get();

        return view('discounts.customer.redeemed', compact('redeemed'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('discounts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDiscountRequest $request)
    {
        $data = $request->validated();
        $data['code'] = strtoupper(Str::random(6));

        Discount::create($data);

        return redirect()->route('discounts.index')->with('success', 'Discount created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Discount $discount)
    {
        return view('discounts.edit', compact('discount'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDiscountRequest $request, Discount $discount)
    {
        $data = $request->validated();

        $discount->update($data);

        return redirect()->route('discounts.index')->with('success', 'Discount updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Discount $discount)
    {
        $discount->delete();

        return redirect()->route('discounts.index')->with('success', 'Discount deleted successfully.');
    }

    /**
     * Redeem a discount using the given code.
     *
     * @param \App\Http\Requests\RedeemDiscountRequest $request
     * @param \App\Models\Discount $discount
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function redeem(RedeemDiscountRequest $request, Discount $discount)
    {
        $user = auth()->user();

        DB::transaction(function () use ($user, $discount) {

            // Lock the user points row to prevent race conditions
            $points = Point::where('user_id', $user->id)
                ->lockForUpdate()
                ->firstOrFail();

            // Re-check duplicate inside transaction (true safety)
            $alreadyRedeemed = RedeemedDiscount::where('user_id', $user->id)
                ->where('discount_id', $discount->id)
                ->lockForUpdate()
                ->exists();

            if ($alreadyRedeemed) {
                throw ValidationException::withMessages([
                    'duplicate' => 'You have already redeemed this discount code.'
                ]);
            }

            // Atomic balance check
            if ($points->points < $discount->points_required) {
                throw ValidationException::withMessages([
                    'points' => 'You do not have enough points.'
                ]);
            }

            // Deduct safely
            $points->decrement('points', $discount->points_required);

            // Create redemption record
            RedeemedDiscount::create([
                'user_id'     => $user->id,
                'discount_id' => $discount->id,
                'is_used'     => false,
            ]);
        });

        return back()->with('success', 'Discount redeemed successfully!');
    }

    /**
     * Validate a discount code.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function validateCode(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string'
        ]);

        $userId = auth()->id();

        if (!$userId) {
            return response()->json([
                'valid' => false,
                'message' => 'Authentication required.'
            ], 401);
        }

        $redeemed = RedeemedDiscount::query()
            ->where('user_id', $userId)
            ->whereHas('discount', function ($q) use ($validated) {
                $q->where('code', $validated['code'])
                    ->where(function ($q) {
                        $q->whereNull('expires_at')
                            ->orWhere('expires_at', '>=', now());
                    });
            })
            ->with('discount')
            ->first();

        if (!$redeemed) {
            return response()->json([
                'valid' => false,
                'message' => 'Invalid, expired, or unauthorized code.'
            ]);
        }

        if ($redeemed->is_used) {
            $message = 'This discount code has already been used';

            if ($redeemed->used_at) {
                $message .= ' on ' . $redeemed->used_at->format('Y-m-d H:i');
            }

            return response()->json([
                'valid' => false,
                'message' => $message
            ]);
        }

        return response()->json([
            'valid' => true,
            'discount_percent' => $redeemed->discount->discount_percent
        ]);
    }
}
