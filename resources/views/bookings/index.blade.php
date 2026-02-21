@extends('layouts.dashboard')

@section('title', 'Bookings')

@section('page-header', 'Bookings')

@section('content')
    <x-success-alert />

    <x-error-alert />

    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <h5 class="card-header">Bookings Table</h5>

                <div class="card-body">
                    <div class="table-responsive">
                        <table id="bookings" class="table table-striped table-bordered first">
                            <thead>
                                <tr>
                                    <th class="text-center">ID</th>
                                    <th class="text-center">Customer</th>
                                    <th class="text-center">Room</th>
                                    <th class="text-center">Check In</th>
                                    <th class="text-center">Check Out</th>
                                    <th class="text-center">Total Paid</th>
                                    <th class="text-center">Payment Status</th>
                                    <th class="text-center">Booking Status</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($bookings as $booking)
                                    <tr>
                                        <td class="text-center">{{ $booking->id }}</td>
                                        <td class="text-center">
                                            <a href="{{ route('users.show', $booking->user) }}">
                                                {{ $booking->user->name }}
                                            </a>
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('rooms.show', $booking->room) }}">
                                                {{ $booking->room->name }}
                                            </a>
                                        </td>
                                        <td class="text-center">{{ $booking->check_in->format('Y-m-d') }}</td>
                                        <td class="text-center">{{ $booking->check_out->format('Y-m-d') }}</td>
                                        <td class="text-center">AED {{ $booking->total_price }}</td>
                                        <td
                                            class="text-center @if ($booking->payment_status === 'pending') text-warning @elseif($booking->payment_status === 'paid') text-success @elseif($booking->payment_status === 'refunded') text-danger @else text-secondary @endif">
                                            {{ ucfirst($booking->payment_status) }}</td>
                                        <td
                                            class="text-center @if ($booking->booking_status === 'active') text-primary @elseif($booking->booking_status === 'completed') text-success @elseif($booking->booking_status === 'cancelled') text-danger @else text-secondary @endif">
                                            {{ ucfirst($booking->booking_status) }}</td>
                                        <td class="text-center">
                                            <x-view-button :url="route('bookings.show', $booking->id)" />
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        $.fn.dataTable.ext.errMode = 'none'; // disables console warnings

        let table = new DataTable('#bookings', {
            responsive: true,
            language: {
                emptyTable: "No bookings found."
            }
        });
    </script>
@endsection
