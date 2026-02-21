<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Http\Requests\StoreReviewRequest;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reviews = Review::all();

        return view('reviews.index', compact('reviews'));
    }

    /**
     * Get the reviews of the manager's hotel.
     *
     * @return \Illuminate\View
     */
    public function manager()
    {
        $user = Auth::user();

        $hotel = $user->hotel;

        $reviews = $hotel->reviews()->latest()->get();

        return view('reviews.manager.index', compact('reviews'));
    }

    /**
     * Get the reviews of the customer.
     */
    public function customer()
    {
        $userID = auth()->id();

        $reviews = Review::where('user_id', $userID)->latest()->get();

        return view('reviews.customer.index', compact('reviews'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Booking $booking)
    {
        // Make sure user owns that booking
        if ($booking->user_id !== auth()->id()) {
            abort(403, 'Unauthorized access.');
        }

        if ($booking->booking_status !== 'completed') {
            abort(403, 'You can only review completed stays.');
        }

        return view('reviews.customer.create', compact('booking'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreReviewRequest $request)
    {
        $validated = $request->validated();

        $booking = Booking::findOrFail($validated['booking_id']);

        // Prevent duplicate review for the same hotel by this user
        if (Review::where('user_id', auth()->id())
            ->where('hotel_id', $booking->room->hotel_id)
            ->exists()
        ) {
            return redirect()
                ->back()
                ->withErrors('You have already submitted a review for this hotel.');
        }

        // Merge validated data with user_id and hotel_id
        $data = array_merge($validated, [
            'user_id'  => auth()->id(),
            'hotel_id' => $booking->room->hotel_id,
        ]);

        // Create the review
        Review::create($data);

        return redirect()->route('customer.reviews.index')
            ->with('success', 'Your review has been submitted successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Review $review)
    {
        return view('reviews.show', compact('review'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Review $review)
    {
        $review->delete();

        return redirect()->back()->with('success', 'Review deleted successfully!');
    }
}
