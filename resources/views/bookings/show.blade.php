@extends('layouts.dashboard')

@section('title', 'Booking')

@section('page-header', 'Booking')

@section('content')
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Booking Details</h5>
                    @role('customer')
                        <x-back-button route="customer.bookings.index" label="My Bookings" />
                    @endrole
                    @role('hotel_manager')
                        <x-back-button route="manager.bookings.index" label="My Bookings" />
                    @endrole
                    @role('admin')
                        <x-back-button route="bookings.index" label="Bookings" />
                    @endrole
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 mt-3">
                            <h6 class="text-muted">ID</h6>
                            <p>{{ $booking->id }}</p>
                        </div>
                        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 mt-3">
                            <h6 class="text-muted">Customer</h6>
                            @role('admin')
                                <a href="{{ route('users.show', $booking->user) }}">
                                    <p>{{ $booking->user->name }}</p>
                                </a>
                            @endrole
                            @role('hotel_manager|customer')
                                <p>{{ $booking->user->name }}</p>
                            @endrole
                        </div>
                        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 mt-3">
                            <h6 class="text-muted">Room</h6>
                            <p>
                                @role('admin|hotel_manager')
                                    <a href="{{ route('rooms.show', $booking->room) }}">{{ $booking->room->name }}</a>
                                @endrole
                                @role('customer')
                                    {{ $booking->room->name }}
                                @endrole
                            </p>
                        </div>
                        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 mt-3">
                            <h6 class="text-muted">Check In</h6>
                            <p>
                                {{ $booking->check_in->format('Y-m-d') }}
                            </p>
                        </div>
                        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 mt-3">
                            <h6 class="text-muted">Check Out</h6>
                            <p>
                                {{ $booking->check_out->format('Y-m-d') }}
                            </p>
                        </div>
                        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 mt-3">
                            <h6 class="text-muted">Total Price</h6>
                            <p>
                                AED {{ $booking->total_price }}
                            </p>
                        </div>
                        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 mt-3">
                            <h6 class="text-muted">Payment Status</h6>
                            <p
                                class="@if ($booking->payment_status === 'pending') text-warning @elseif($booking->payment_status === 'paid') text-success @elseif($booking->payment_status === 'refunded') text-danger @else text-secondary @endif">
                                {{ ucfirst($booking->payment_status) }}
                            </p>
                        </div>
                        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 mt-3">
                            <h6 class="text-muted">Booking Status</h6>
                            <p
                                class="@if ($booking->booking_status === 'active') text-primary @elseif($booking->booking_status === 'completed') text-success @elseif($booking->booking_status === 'cancelled') text-danger @else text-secondary @endif">
                                {{ ucfirst($booking->booking_status) }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
