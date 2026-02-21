<?php

namespace App\Http\Controllers;

use App\Http\Requests\PrepareBookingRequest;
use App\Models\Booking;
use App\Models\Room;
use App\Notifications\BookingCancelledNotification;
use Carbon\Carbon;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bookings = Booking::all();

        return view('bookings.index', compact('bookings'));
    }

    /**
     * Get the bookings of the manager.
     *
     * @return \Illuminate\View\View
     */
    public function manager()
    {
        $managerId = auth()->id();

        $bookings = Booking::whereHas('room.hotel', function ($query) use ($managerId) {
            $query->where('manager_id', $managerId);
        })->get();

        return view('bookings.manager.index', compact('bookings'));
    }

    /**
     * Get the bookings of the customer.
     *
     * @return \Illuminate\View\View
     */
    public function customer()
    {
        $customerID = auth()->id();

        $bookings = Booking::where('user_id', $customerID)->get();

        return view('bookings.customer.index', compact('bookings'));
    }

    /**
     * Prepare booking request
     *
     * @param PrepareBookingRequest $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Http\Exceptions\HttpException
     */
    public function prepare(PrepareBookingRequest $request)
    {
        $room = Room::findOrFail($request->room_id);

        // Server-side availability check
        $conflict = $room->bookings()
            ->where(function ($q) use ($request) {
                $q->whereBetween('check_in', [$request->check_in, $request->check_out])
                    ->orWhereBetween('check_out', [$request->check_in, $request->check_out])
                    ->orWhere(function ($q) use ($request) {
                        $q->where('check_in', '<=', $request->check_in)
                            ->where('check_out', '>=', $request->check_out);
                    });
            })
            ->exists();

        if ($conflict) {
            return back()->withErrors([
                'check_in' => 'Selected dates are no longer available.',
            ]);
        }

        session([
            'booking.check_in'      => $request->check_in,
            'booking.check_out'     => $request->check_out,
            'booking.discount_code' => $request->discount_code ?? null,
        ]);

        return redirect()->route('bookings.checkout', $room);
    }

    /**
     * Show the checkout form for a customer.
     *
     * @param \App\Models\Room $room
     * @return \Illuminate\View\View
     *
     * @throws \Illuminate\Http\Exceptions\HttpException
     */
    public function checkout(Room $room)
    {
        $checkIn = session('booking.check_in');
        $checkOut = session('booking.check_out');

        if (!$checkIn || !$checkOut) {
            return redirect()->route('rooms.show', $room)
                ->withErrors(['dates' => 'Please select your stay dates.']);
        }

        try {
            $checkInDate = Carbon::parse($checkIn);
            $checkOutDate = Carbon::parse($checkOut);
        } catch (\Exception $e) {
            return redirect()->route('rooms.show', $room)
                ->withErrors(['dates' => 'Invalid booking dates.']);
        }

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
            return redirect()->route('rooms.show', $room)
                ->withErrors(['dates' => 'Selected dates are no longer available.']);
        }

        $promo = $room->hotel->activePromotion();

        $pricePerNight = $room->price;

        if ($promo) {
            $pricePerNight = round(
                $room->price * (1 - $promo->discount_percent / 100),
                2
            );
        }

        $total = round($days * $pricePerNight, 2);

        return view('bookings.customer.checkout', [
            'room' => $room,
            'checkIn' => $checkInDate,
            'checkOut' => $checkOutDate,
            'days' => $days,
            'total' => $total,
            'pricePerNight' => $pricePerNight,
            'stripeKey' => config('services.stripe.key'),
            'promo' => $promo,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Booking $booking)
    {
        return view('bookings.show', compact('booking'));
    }

    /**
     * Cancel a booking.
     *
     * @param Booking $booking The booking to be cancelled.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function cancel(Booking $booking)
    {
        if ($booking->booking_status !== 'active') {
            return redirect()->back()->withErrors('Booking cannot be cancelled.');
        }

        // Update booking status
        $booking->update([
            'booking_status' => 'cancelled'
        ]);

        // Notify hotel manager
        $manager = $booking->room->hotel->manager;
        if ($manager) {
            $manager->notify(new BookingCancelledNotification($booking));
        }

        return redirect()->back()->with('success', 'Booking has been cancelled.');
    }

    /**
     * Refund a booking payment.
     *
     * @param Booking $booking The booking to be refunded.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function refund(Booking $booking)
    {
        if ($booking->booking_status !== 'cancelled' || $booking->payment_status !== 'paid') {
            return redirect()->back()->withErrors('Booking cannot be refunded.');
        }

        $booking->update([
            'payment_status' => 'refunded',
        ]);

        return redirect()->route('manager.bookings.index')->with('success', 'Payment has been refunded.');
    }
}
