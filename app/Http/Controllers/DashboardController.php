<?php

namespace App\Http\Controllers;

use App\Models\{Booking, Point, Review, User};

class DashboardController extends Controller
{
    /**
     * Show the dashboard for the authenticated user.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // ======Customer Dashboard ======
        $customer = auth()->user();

        $my_points = Point::where('user_id', $customer->id)->first();

        $totalCustomerBookings = $customer->bookings()->count();
        $totalCustomerReviews = $customer->reviews()->count();
        $totalCustomerRedeemedDiscounts = $customer->redeemedDiscounts()->count();

        $customerBookingsStatus = [
            'active' => $customer->bookings()->where('booking_status', 'active')->count(),
            'completed' => $customer->bookings()->where('booking_status', 'completed')->count(),
            'cancelled' => $customer->bookings()->where('booking_status', 'cancelled')->count(),
        ];

        // Total money spent
        $totalCustomerSpent = $customer->bookings()
            ->where('payment_status', 'paid')
            ->sum('total_price');

        // Monthly spending for Morris Chart
        $customerSpendingByMonth = $customer->bookings()
            ->where('payment_status', 'paid')
            ->selectRaw("DATE_FORMAT(created_at, '%Y-%m') as month, SUM(total_price) as total")
            ->groupBy('month')
            ->orderBy('month', 'ASC')
            ->get()
            ->map(function ($item) {
                return [
                    'x' => $item->month,
                    'y' => (float) $item->total,
                ];
            });

        // ====== Hotel Manager Dashboard ======
        $totalHotelBookings = 0;
        $percentBooked = 0;
        $averageHotelRating = 0;
        $totalRevenue = 0;

        $hotelBookingStatus = [
            'active' => 0,
            'completed' => 0,
            'cancelled' => 0,
        ];

        $hotelSpendingByMonth = [];

        if (auth()->user()->hasRole('hotel_manager') && auth()->user()->hotel) {
            $hotel = auth()->user()->hotel;

            $totalHotelBookings = $hotel->bookings()->count();
            $totalHotelRooms = $hotel->rooms()->count();
            $bookedRooms = $hotel->rooms()
                ->whereHas('bookings', fn($q) => $q->where('booking_status', 'active'))
                ->count();
            $percentBooked = $totalHotelRooms > 0 ? round(($bookedRooms / $totalHotelRooms) * 100, 0) : 0;

            $averageHotelRating = round($hotel->reviews()->avg('rating'), 2);
            $totalRevenue = $hotel->bookings()->where('payment_status', 'paid')->sum('total_price');

            $hotelBookingStatus = [
                'active' => $hotel->bookings()->where('booking_status', 'active')->count(),
                'completed' => $hotel->bookings()->where('booking_status', 'completed')->count(),
                'cancelled' => $hotel->bookings()->where('booking_status', 'cancelled')->count(),
            ];

            $hotelSpendingByMonth = Booking::join('rooms', 'rooms.id', '=', 'bookings.room_id')
                ->where('rooms.hotel_id', $hotel->id)
                ->where('bookings.payment_status', 'paid')
                ->selectRaw("DATE_FORMAT(bookings.created_at, '%Y-%m') as month, SUM(bookings.total_price) as total")
                ->groupBy('month')
                ->orderBy('month', 'ASC')
                ->get()
                ->map(function ($item) {
                    return [
                        'x' => $item->month,
                        'y' => (float) $item->total,
                    ];
                });
        }

        // ====== Admin Dashboard ======
        $totalCustomers = User::role('customer')->count();

        $totalManagers = User::role('hotel_manager')->count();

        $totalBookings = Booking::all()->count();

        $globalAverageRating = round(Review::avg('rating'), 2);

        $adminBookingStatus = [
            'active' => Booking::where('booking_status', 'active')->count(),
            'completed' => Booking::where('booking_status', 'completed')->count(),
            'cancelled' => Booking::where('booking_status', 'cancelled')->count(),
        ];

        $adminSpendingByMonth = Booking::where('payment_status', 'paid')
            ->selectRaw("DATE_FORMAT(created_at, '%Y-%m') as month, SUM(total_price) as total")
            ->groupBy('month')
            ->orderBy('month', 'ASC')
            ->get()
            ->map(function ($item) {
                return [
                    'x' => $item->month,
                    'y' => (float) $item->total,
                ];
            });

        return view('dashboard', compact(
            'my_points',
            'totalCustomerBookings',
            'totalCustomerReviews',
            'totalCustomerRedeemedDiscounts',
            'totalHotelBookings',
            'percentBooked',
            'averageHotelRating',
            'totalRevenue',
            'totalCustomers',
            'totalManagers',
            'totalBookings',
            'globalAverageRating',
            'customerBookingsStatus',
            'totalCustomerSpent',
            'customerSpendingByMonth',
            'hotelBookingStatus',
            'hotelSpendingByMonth',
            'adminBookingStatus',
            'adminSpendingByMonth',
        ));
    }
}
