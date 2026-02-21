@extends('layouts.dashboard')

@section('title', 'Hotel')

@section('page-header', 'Hotel')

@section('content')
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Hotel Information</h5>
                    @role('hotel_manager')
                        <x-back-button route="manager.hotels.index" label="My Hotel" />
                    @endrole

                    @role('admin')
                        <x-back-button route="hotels.index" label="Hotels" />
                    @endrole
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="card mb-3">
                                <div class="card-header">
                                    <h5 class="mb-0">Hotel Details</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 mt-3">
                                            <h5>Name</h5>
                                            <p>{{ $hotel->name }}</p>
                                        </div>
                                        @role('admin')
                                            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 mt-3">
                                                <h5>Hotel Manager</h5>
                                                <p>
                                                    <a href="{{ route('users.show', $hotel->manager) }}">
                                                        {{ $hotel->manager->name }}
                                                    </a>
                                                </p>
                                            </div>
                                        @endrole
                                        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 mt-3">
                                            <h5>Description</h5>
                                            <p>{{ $hotel->description }}</p>
                                        </div>
                                        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 mt-3">
                                            <h5>Region</h5>
                                            <p>{{ $hotel->region }}</p>
                                        </div>
                                        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 mt-3">
                                            <h5>Country</h5>
                                            <p>{{ $hotel->country }}</p>
                                        </div>
                                        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 mt-3">
                                            <h5>City</h5>
                                            <p>{{ $hotel->city }}</p>
                                        </div>
                                        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 mt-3">
                                            <h5>Street</h5>
                                            <p>{{ $hotel->street }}</p>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Hotel Images</h5>
                        </div>
                        <div class="card-body">
                            @if ($media->isEmpty())
                                <p class="text-muted text-center mb-0">No images uploaded for this hotel.</p>
                            @else
                                <div class="row">
                                    @foreach ($media as $image)
                                        <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                                            <div class="image-container shadow-sm">
                                                <img src="{{ $image['url'] }}" class="img-fluid rounded" alt="Hotel Image">
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Features</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                @if ($hotel->pool)
                                    <div class="col-md-3 mt-3">
                                        <h5 class="text-muted d-flex align-items-center gap-2">
                                            <i class="ph ph-swimming-pool big-i mr-2"></i>
                                            Swimming Pool
                                        </h5>
                                    </div>
                                @endif

                                @if ($hotel->wifi)
                                    <div class="col-md-3 mt-3">
                                        <h5 class="text-muted d-flex align-items-center gap-2"><i
                                                class="ph ph-wifi-high big-i mr-2"></i> Free Wifi</h5>
                                    </div>
                                @endif

                                @if ($hotel->breakfast)
                                    <div class="col-md-3 mt-3">
                                        <h5 class="text-muted d-flex align-items-center gap-2"><i
                                                class="ph ph-fork-knife big-i mr-2"></i> Breakfast</h5>
                                    </div>
                                @endif

                                @if ($hotel->gym)
                                    <div class="col-md-3 mt-3">
                                        <h5 class="text-muted d-flex align-items-center gap-2"><i
                                                class="ph ph-barbell big-i mr-2"></i>
                                            Gym</h5>
                                    </div>
                                @endif

                                @if ($hotel->pets_allowed)
                                    <div class="col-md-3 mt-3">
                                        <h5 class="text-muted d-flex align-items-center gap-2"><i
                                                class="ph ph-paw-print big-i mr-2"></i>
                                            Pets Allowed</h5>
                                    </div>
                                @endif

                                @if ($hotel->environment)
                                    <div class="col-md-3 mt-3">
                                        <h5 class="text-muted d-flex align-items-center gap-2"><i
                                                class="ph ph-leaf big-i mr-2"></i>
                                            Eco-Friendly</h5>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
