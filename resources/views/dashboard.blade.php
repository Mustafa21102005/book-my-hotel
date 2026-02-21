@extends('layouts.dashboard')

@section('title', 'Dashboard')

@section('page-header', 'Dashboard')

@section('css')
    <style>
        .ct-chart-booking .ct-series-a .ct-slice-donut {
            stroke: #4fc3f7 !important;
        }

        .ct-chart-booking .ct-series-b .ct-slice-donut {
            stroke: #ffb878 !important;
        }

        .ct-chart-booking .ct-series-c .ct-slice-donut {
            stroke: #fa4251 !important;
        }
    </style>
@endsection

@section('content')
    <div class="ecommerce-widget">
        <div class="row">
            @role('customer')
                {{-- My Points for Customer --}}
                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                    <div class="card border-3 border-top border-top-primary">
                        <div class="card-body">
                            <h5 class="text-muted">My Points</h5>
                            <div class="metric-value d-inline-block">
                                <h1 class="mb-1">{{ $my_points->points ?? 0 }}</h1>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Total Customer Booking --}}
                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                    <div class="card border-3 border-top border-top-primary">
                        <div class="card-body">
                            <h5 class="text-muted">My Bookings</h5>
                            <div class="metric-value d-inline-block">
                                <h1 class="mb-1">{{ $totalCustomerBookings }}</h1>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Total Customer Reviews --}}
                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                    <div class="card border-3 border-top border-top-primary">
                        <div class="card-body">
                            <h5 class="text-muted">My Reviews</h5>
                            <div class="metric-value d-inline-block">
                                <h1 class="mb-1">{{ $totalCustomerReviews }}</h1>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Total Customer Redeemed Discounts --}}
                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                    <div class="card border-3 border-top border-top-primary">
                        <div class="card-body">
                            <h5 class="text-muted">My Redeemed Discounts</h5>
                            <div class="metric-value d-inline-block">
                                <h1 class="mb-1">{{ $totalCustomerRedeemedDiscounts }}</h1>
                            </div>
                        </div>
                    </div>
                </div>
            @endrole

            @role('hotel_manager')
                {{-- Total Bookings for Hotel Manager --}}
                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                    <div class="card border-3 border-top border-top-primary">
                        <div class="card-body">
                            <h5 class="text-muted">Total Bookings</h5>
                            <div class="metric-value d-inline-block">
                                <h1 class="mb-1">{{ $totalHotelBookings }}</h1>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Rooms Booking Percentage --}}
                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                    <div class="card border-3 border-top border-top-primary">
                        <div class="card-body">
                            <h5 class="text-muted">Booked Rooms Percentage</h5>
                            <div class="metric-value d-inline-block">
                                <h1 class="mb-1">{{ $percentBooked }}%</h1>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Reviews Average --}}
                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                    <div class="card border-3 border-top border-top-primary">
                        <div class="card-body">
                            <h5 class="text-muted">Reviews Average</h5>
                            <div class="metric-value d-inline-block">
                                <h1 class="mb-1">{{ $averageHotelRating ?? '0' }}</h1>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Total Revenue --}}
                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                    <div class="card border-3 border-top border-top-primary">
                        <div class="card-body">
                            <h5 class="text-muted">Total Revenue</h5>
                            <div class="metric-value d-inline-block">
                                <h1 class="mb-1">AED {{ $totalRevenue }}</h1>
                            </div>
                        </div>
                    </div>
                </div>
            @endrole

            @role('admin')
                {{-- Total Amount of Customers --}}
                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                    <div class="card border-3 border-top border-top-primary">
                        <div class="card-body">
                            <h5 class="text-muted">Total Customers</h5>
                            <div class="metric-value d-inline-block">
                                <h1 class="mb-1">{{ $totalCustomers }}</h1>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Total Amount of Managers --}}
                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                    <div class="card border-3 border-top border-top-primary">
                        <div class="card-body">
                            <h5 class="text-muted">Total Managers</h5>
                            <div class="metric-value d-inline-block">
                                <h1 class="mb-1">{{ $totalManagers }}</h1>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Total Amount of Bookings --}}
                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                    <div class="card border-3 border-top border-top-primary">
                        <div class="card-body">
                            <h5 class="text-muted">Total Bookings</h5>
                            <div class="metric-value d-inline-block">
                                <h1 class="mb-1">{{ $totalBookings }}</h1>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Total Average Hotel Rating --}}
                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                    <div class="card border-3 border-top border-top-primary">
                        <div class="card-body">
                            <h5 class="text-muted">Average Rating (All Hotels)</h5>
                            <div class="metric-value d-inline-block">
                                <h1 class="mb-1">{{ $globalAverageRating }}</h1>
                            </div>
                        </div>
                    </div>
                </div>
            @endrole
        </div>

        <div class="row">
            @role('customer')
                <div class="col-xl-5 col-lg-5 col-md-12 col-sm-12 col-12">
                    <div class="card">
                        <h5 class="card-header">My Booking Status</h5>
                        <div class="card-body">
                            <div id="customer_booking_status_chart" style="height: 420px;"></div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-7 col-lg-7 col-md-12 col-sm-12 col-12">
                    <div class="card">
                        <h5 class="card-header">Total Money Spent</h5>
                        <div class="card-body">
                            <div id="morris_totalrevenue"></div>
                        </div>
                        <div class="card-footer">
                            <p class="display-7 font-weight-bold">
                                Total Amount:
                                <span class="text-primary d-inline-block">
                                    AED {{ number_format($totalCustomerSpent, 2) }}
                                </span>
                            </p>
                        </div>
                    </div>
                </div>
            @endrole

            @role('hotel_manager')
                <div class="col-xl-5 col-lg-5 col-md-12 col-sm-12 col-12">
                    <div class="card">
                        <h5 class="card-header">Hotel Booking Status</h5>
                        <div class="card-body">
                            <div id="hotel_booking_status_chart" style="height: 420px;"></div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-7 col-lg-7 col-md-12 col-sm-12 col-12">
                    <div class="card">
                        <h5 class="card-header">Total Hotel Revenue</h5>
                        <div class="card-body">
                            <div id="morris_hotelrevenue"></div>
                        </div>
                        <div class="card-footer">
                            <p class="display-7 font-weight-bold">
                                Total Revenue:
                                <span class="text-primary d-inline-block">
                                    AED {{ number_format($totalRevenue ?? 0, 2) }}
                                </span>
                            </p>
                        </div>
                    </div>
                </div>
            @endrole

            @role('admin')
                <div class="col-xl-5 col-lg-5 col-md-12 col-sm-12 col-12">
                    <div class="card">
                        <h5 class="card-header">All Bookings Status</h5>
                        <div class="card-body">
                            <div id="admin_booking_status_chart" style="height: 420px;"></div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-7 col-lg-7 col-md-12 col-sm-12 col-12">
                    <div class="card">
                        <h5 class="card-header">Total Revenue (All Bookings)</h5>
                        <div class="card-body">
                            <div id="morris_admin_revenue"></div>
                        </div>
                        <div class="card-footer">
                            <p class="display-7 font-weight-bold">
                                Total Revenue:
                                <span class="text-primary d-inline-block">
                                    AED {{ number_format($adminSpendingByMonth->sum('y'), 2) }}
                                </span>
                            </p>
                        </div>
                    </div>
                </div>
            @endrole
        </div>
    </div>
@endsection

@section('js')
    @role('customer')
        <script>
            var customerStatusChart = c3.generate({
                bindto: "#customer_booking_status_chart",
                data: {
                    columns: [
                        ["Active", {{ $customerBookingsStatus['active'] }}],
                        ["Completed", {{ $customerBookingsStatus['completed'] }}],
                        ["Cancelled", {{ $customerBookingsStatus['cancelled'] }}],
                    ],
                    type: 'donut',
                    colors: {
                        Active: '#5969ff',
                        Completed: '#2ec551',
                        Cancelled: '#ff407b'
                    }
                },
                donut: {
                    title: "Booking Status"
                }
            });

            var customerSpending = @json($customerSpendingByMonth);

            Morris.Area({
                element: 'morris_totalrevenue',
                behaveLikeLine: true,
                data: customerSpending,
                xkey: 'x',
                ykeys: ['y'],
                labels: ['Amount Spent'],
                lineColors: ['#5969ff'],
                resize: true
            });
        </script>
    @endrole
    @role('hotel_manager')
        <script>
            var hotelBookingStatusChart = c3.generate({
                bindto: "#hotel_booking_status_chart",
                data: {
                    columns: [
                        ["Active", {{ $hotelBookingStatus['active'] }}],
                        ["Completed", {{ $hotelBookingStatus['completed'] }}],
                        ["Cancelled", {{ $hotelBookingStatus['cancelled'] }}],
                    ],
                    type: 'donut',
                    colors: {
                        Active: '#5969ff',
                        Completed: '#2ec551',
                        Cancelled: '#ff407b'
                    }
                },
                donut: {
                    title: "Hotel Booking Status"
                }
            });

            var hotelSpending = @json($hotelSpendingByMonth);

            Morris.Area({
                element: 'morris_hotelrevenue',
                behaveLikeLine: true,
                data: hotelSpending,
                xkey: 'x',
                ykeys: ['y'],
                labels: ['Revenue'],
                lineColors: ['#5969ff'],
                resize: true
            });
        </script>
    @endrole
    @role('admin')
        <script>
            // Admin Booking Status Donut
            var adminBookingStatusChart = c3.generate({
                bindto: "#admin_booking_status_chart",
                data: {
                    columns: [
                        ["Active", {{ $adminBookingStatus['active'] }}],
                        ["Completed", {{ $adminBookingStatus['completed'] }}],
                        ["Cancelled", {{ $adminBookingStatus['cancelled'] }}],
                    ],
                    type: 'donut',
                    colors: {
                        Active: '#5969ff',
                        Completed: '#2ec551',
                        Cancelled: '#ff407b'
                    }
                },
                donut: {
                    title: "All Bookings Status"
                }
            });

            // Admin Total Revenue Morris Area
            var adminSpending = @json($adminSpendingByMonth);

            Morris.Area({
                element: 'morris_admin_revenue',
                behaveLikeLine: true,
                data: adminSpending,
                xkey: 'x',
                ykeys: ['y'],
                labels: ['Revenue'],
                lineColors: ['#5969ff'],
                resize: true
            });
        </script>
    @endrole
@endsection
