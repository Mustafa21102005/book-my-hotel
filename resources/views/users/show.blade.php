@extends('layouts.dashboard')

@section('title', 'User')

@section('page-header', 'User')

@section('content')
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">User Information</h5>
                    <x-back-button route="users.index" label="Users" />
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 mt-3">
                            <h6 class="text-muted">ID</h6>
                            <p>{{ $user->id }}</p>
                        </div>
                        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 mt-3">
                            <h6 class="text-muted">Name</h6>
                            <p>{{ $user->name }}</p>
                        </div>
                        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 mt-3">
                            <h6 class="text-muted">Email</h6>
                            <p>{{ $user->email }}</p>
                        </div>
                        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 mt-3">
                            <h6 class="text-muted">Email Verified</h6>
                            <p>
                                @if ($user->email_verified_at)
                                    <i class="ph ph-check-fat text-success big-i"></i>
                                @else
                                    <i class="ph ph-x text-danger big-i"></i>
                                @endif
                            </p>
                        </div>
                        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 mt-3">
                            <h6 class="text-muted">Role</h6>
                            <p>
                                @php
                                    $role = $user->roles->first()->name;
                                    if ($role === 'hotel_manager') {
                                        $role = 'Hotel Manager';
                                    }
                                @endphp
                                {{ ucfirst($role) }}
                            </p>
                        </div>

                        @if ($user->roles->first()->name === 'hotel_manager')
                            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 mt-3">
                                <h6 class="text-muted">Hotel</h6>
                                <p>
                                    @if ($user->hotel)
                                        <a href="{{ route('hotels.show', $user->hotel) }}">
                                            {{ $user->hotel->name }}
                                        </a>
                                    @else
                                        <span>No Hotel Created Yet</span>
                                    @endif
                                </p>
                            </div>
                            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 mt-3">
                                <h6 class="text-muted">Average Reviews</h6>
                                <p>
                                    @if ($user->hotel && $user->hotel->reviews->isNotEmpty())
                                        {{ number_format($user->hotel->reviews->avg('rating'), 1) }}
                                    @else
                                        <span>No Reviews Posted Yet</span>
                                    @endif
                                </p>
                            </div>
                            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 mt-3">
                                <h6 class="text-muted">Total Hotel Bookings</h6>
                                <p>
                                    @if ($user->hotel)
                                        {{ $user->hotel->bookings->count() }}
                                    @else
                                        <span>No Bookings Yet</span>
                                    @endif
                                </p>
                            </div>
                        @endif

                        @if ($user->roles->first()->name === 'customer')
                            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 mt-3">
                                <h6 class="text-muted">Total Reviews</h6>
                                <p>
                                    {{ $user->reviews->count() ?? 0 }}
                                </p>
                            </div>
                            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 mt-3">
                                <h6 class="text-muted">Total Redeemed Discounts</h6>
                                <p>
                                    {{ $user->redeemedDiscounts->count() ?? 0 }}
                                </p>
                            </div>
                            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 mt-3">
                                <h6 class="text-muted">Total Bookings</h6>
                                <p>
                                    {{ $user->bookings->count() ?? 0 }}
                                </p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
