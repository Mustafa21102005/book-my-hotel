<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Discount;
use App\Models\Point;
use App\Models\Room;
use App\Models\SustainabilityReward;
use App\Notifications\BookingConfirmed;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Stripe\StripeClient;

class StripeController extends Controller
{
    /**
     * Create Stripe Checkout Session (replaces checkout.php)
     */
    public function createSession(Room $room)
    {
        $checkIn = session('booking.check_in');
        $checkOut = session('booking.check_out');
        $discountCode = session('booking.discount_code');

        if (!$checkIn || !$checkOut) {
            abort(422, 'Missing booking dates.');
        }

        $checkInDate = Carbon::parse($checkIn);
        $checkOutDate = Carbon::parse($checkOut);

        $days = max(1, $checkInDate->diffInDays($checkOutDate));

        // Availability recheck
        $conflict = $room->bookings()
            ->where(function ($q) use ($checkIn, $checkOut) {
                $q->whereBetween('check_in', [$checkIn, $checkOut])
                    ->orWhereBetween('check_out', [$checkIn, $checkOut])
                    ->orWhere(function ($q) use ($checkIn, $checkOut) {
                        $q->where('check_in', '<=', $checkIn)
                            ->where('check_out', '>=', $checkOut);
                    });
            })
            ->exists();

        if ($conflict) {
            abort(422, 'Selected dates are no longer available.');
        }

        // Base price
        $promo = $room->hotel->activePromotion();
        $pricePerNight = $room->price;

        if ($promo) {
            $pricePerNight = round(
                $room->price * (1 - $promo->discount_percent / 100),
                2
            );
        }

        $total = round($days * $pricePerNight, 2);

        // Secure discount calculation
        $discountPercent = 0;

        if ($discountCode) {
            $discount = Discount::where('code', $discountCode)->first();

            if ($discount) {
                $userDiscount = $discount->redeemed_discounts()
                    ->where('user_id', auth()->id())
                    ->where('is_used', false)
                    ->first();

                if ($userDiscount) {
                    $discountPercent = $discount->discount_percent;
                }
            }
        }

        $totalAfterDiscount = round(
            $total * (1 - $discountPercent / 100),
            2
        );

        $stripe = new StripeClient(config('services.stripe.secret'));

        $session = $stripe->checkout->sessions->create([
            'ui_mode' => 'embedded',
            'mode' => 'payment',
            'return_url' => route('stripe.return') . '?session_id={CHECKOUT_SESSION_ID}',
            'customer_email' => auth()->user()->email,
            'line_items' => [[
                'quantity' => 1,
                'price_data' => [
                    'currency' => 'aed',
                    'unit_amount' => (int) round($totalAfterDiscount * 100),
                    'product_data' => [
                        'name' => 'Room Booking - #' . $room->id,
                    ],
                ],
            ]],
            'metadata' => [
                'user_id' => auth()->id(),
                'room_id' => $room->id,
                'check_in' => $checkIn,
                'check_out' => $checkOut,
                'discount_code' => $discountCode,
            ],
        ]);

        return response()->json([
            'clientSecret' => $session->client_secret,
        ]);
    }

    /**
     * Status endpoint (replaces status.php)
     */
    public function checkStatus(Request $request)
    {
        $request->validate([
            'session_id' => 'required|string'
        ]);

        $stripe = new StripeClient(config('services.stripe.secret'));

        $session = $stripe->checkout->sessions->retrieve(
            $request->session_id
        );

        // Security: verify ownership
        if ($session->metadata->user_id != auth()->id()) {
            abort(403, 'Unauthorized session.');
        }

        if (
            $session->status === 'complete' &&
            $session->payment_status === 'paid'
        ) {
            $this->storeBooking($session);
        }

        return response()->json([
            'status' => $session->status,
            'payment_status' => $session->payment_status,
            'customer_email' => $session->customer_details->email ?? null,
        ]);
    }

    /**
     * Return page after payment
     */
    public function returnPage(Request $request)
    {
        $request->validate([
            'session_id' => 'required|string'
        ]);

        $stripe = new StripeClient(config('services.stripe.secret'));

        $session = $stripe->checkout->sessions->retrieve(
            $request->session_id
        );

        // Verify ownership
        if ($session->metadata->user_id != auth()->id()) {
            abort(403, 'Unauthorized session.');
        }

        // Verify payment success
        if (
            $session->status === 'complete' &&
            $session->payment_status === 'paid'
        ) {
            $this->storeBooking($session);
        } else {
            return redirect()->route('home')
                ->withErrors(['payment' => 'Payment not completed.']);
        }

        // Eager-load hotel only
        $room = Room::with('hotel')->find($session->metadata->room_id);

        $earnedEcoPoints = false;

        if ($room && $room->hotel && $room->hotel->environment) {
            $earnedEcoPoints = true;
        }

        return view('bookings.status', [
            'customerEmail' => $session->customer_details->email ?? null,
            'earnedEcoPoints' => $earnedEcoPoints,
        ]);
    }

    /**
     * Store booking in database after Stripe payment is successful
     *
     * @param \Stripe\Checkout\Session $session
     * @return \App\Models\Booking
     */
    public function storeBooking($session)
    {
        if (
            $session->status !== 'complete' ||
            $session->payment_status !== 'paid'
        ) {
            throw new Exception('Invalid payment state.');
        }

        return DB::transaction(function () use ($session) {

            $metadata = $session->metadata;

            $booking = Booking::updateOrCreate(
                ['stripe_session_id' => $session->id],
                [
                    'user_id' => $metadata->user_id,
                    'room_id' => $metadata->room_id,
                    'check_in' => $metadata->check_in,
                    'check_out' => $metadata->check_out,
                    'total_price' => $session->amount_total / 100,
                    'payment_status' => 'paid',
                    'booking_status' => 'active',
                ]
            );

            if ($booking->wasRecentlyCreated && !empty($metadata->discount_code)) {

                $discount = Discount::where('code', $metadata->discount_code)->first();

                if ($discount) {
                    $userDiscount = $discount->redeemed_discounts()
                        ->where('user_id', $metadata->user_id)
                        ->where('is_used', false)
                        ->lockForUpdate()
                        ->first();

                    if (! $userDiscount) {
                        throw new \Exception('Discount no longer available.');
                    }

                    $userDiscount->update([
                        'is_used' => true,
                        'used_at' => now(),
                    ]);
                }
            }

            if ($booking->wasRecentlyCreated) {
                $reward = SustainabilityReward::firstOrCreate(
                    ['user_id' => $metadata->user_id, 'booking_id' => $booking->id],
                    ['points' => 20]
                );

                if ($reward->wasRecentlyCreated) {
                    $points = Point::firstOrCreate(
                        ['user_id' => $metadata->user_id],
                        ['points' => 0]
                    );

                    $points->increment('points', 20);
                }

                $booking->user->notify(new BookingConfirmed($booking));
            }

            return $booking;
        });
    }
}
