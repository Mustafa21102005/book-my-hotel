@extends('layouts.dashboard')

@section('title', 'Review')

@section('page-header', 'Review')

@section('content')
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Review Details</h5>
                    @role('customer')
                        <x-back-button route="customer.reviews.index" label="My Reviews" />
                    @endrole
                    @role('hotel_manager')
                        <x-back-button route="manager.reviews.index" label="My Reviews" />
                    @endrole
                    @role('admin')
                        <x-back-button route="reviews.index" label="Reviews" />
                    @endrole
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 mt-3">
                            <h6 class="text-muted">ID</h6>
                            <p>{{ $review->id }}</p>
                        </div>
                        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 mt-3">
                            <h6 class="text-muted">Customer</h6>
                            @role('admin')
                                <p>
                                    <a href="{{ route('users.show', $review->user) }}">{{ $review->user->name }}</a>
                                </p>
                            @endrole
                            @role('hotel_manager|customer')
                                <p>
                                    {{ $review->user->name }}
                                </p>
                            @endrole
                        </div>
                        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 mt-3">
                            <h6 class="text-muted">Hotel</h6>
                            <p>
                                @role('hotel_manager|admin')
                                    <a href="{{ route('hotels.show', $review->hotel) }}">{{ $review->hotel->name }}</a>
                                @endrole
                                @role('customer')
                                    {{ $review->hotel->name }}
                                @endrole
                            </p>
                        </div>
                        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 mt-3">
                            <h6 class="text-muted">Rating</h6>
                            <p>
                                @for ($i = 1; $i <= 5; $i++)
                                    @if ($i <= $review->rating)
                                        <i class="ph-fill ph-star text-warning"></i>
                                    @else
                                        <i class="ph ph-star text-warning"></i>
                                    @endif
                                @endfor
                            </p>
                        </div>
                        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 mt-3">
                            <h6 class="text-muted">Comment</h6>
                            <p>
                                {{ $review->comment ?? 'No comment' }}</td>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
