@extends('layouts.dashboard')

@section('title', 'My Bookings')

@section('page-header', 'My Bookings')

@section('content')
    <x-success-alert />

    <x-error-alert />

    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <h5 class="card-header">My Bookings Table</h5>

                <div class="card-body">
                    <div class="table-responsive">
                        <table id="bookings" class="table table-striped table-bordered first">
                            <thead>
                                <tr>
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
                                        <td class="text-center">
                                            {{ $booking->room->name }}
                                        </td>
                                        <td class="text-center">
                                            {{ $booking->check_in->format('Y-m-d') }}
                                        </td>
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

                                            @if ($booking->booking_status === 'active')
                                                <button type="button" class="btn btn-outline-danger btn-sm"
                                                    data-toggle="modal"
                                                    data-target="#cancelBookingModal{{ $booking->id }}">
                                                    Cancel
                                                </button>
                                            @endif

                                            {{-- Cancel Booking Modal --}}
                                            <div class="modal fade" id="cancelBookingModal{{ $booking->id }}"
                                                tabindex="-1" role="dialog"
                                                aria-labelledby="cancelBookingModal{{ $booking->id }}Label"
                                                aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title"
                                                                id="cancelBookingModal{{ $booking->id }}Label">
                                                                Cancel Booking
                                                            </h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            Are you sure you want to cancel your booking for
                                                            <b>{{ $booking->room->name }}</b>?
                                                            <br>
                                                            **Please read our<a href="{{ route('cancellation') }}"
                                                                target="_blank">
                                                                <b>Cancellation Policy</b></a> before proceeding.**
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-dismiss="modal">
                                                                No, Keep the Booking
                                                            </button>
                                                            <form action="{{ route('bookings.cancel', $booking->id) }}"
                                                                method="POST">
                                                                @csrf
                                                                @method('PATCH')
                                                                <button type="submit" class="btn btn-danger">
                                                                    Yes, Cancel Booking
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
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
