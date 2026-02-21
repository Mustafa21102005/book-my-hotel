@extends('layouts.dashboard')

@section('title', 'Room')

@section('page-header', 'Room')

@section('content')
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Room Information</h5>
                    @role('hotel_manager')
                        <x-back-button route="manager.rooms.index" label="My Rooms" />
                    @endrole
                    @role('admin')
                        <x-back-button route="rooms.index" label="Rooms" />
                    @endrole
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="card mb-3">
                                <div class="card-header">
                                    <h5 class="mb-0">Room Information</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 mt-3">
                                            <h5>Name</h5>
                                            <p>{{ $room->name }}</p>
                                        </div>
                                        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 mt-3">
                                            <h5>Type</h5>
                                            <p>{{ ucfirst($room->type) }}</p>
                                        </div>
                                        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 mt-3">
                                            <h5>Price</h5>
                                            <p>AED {{ $room->price }}</p>
                                        </div>
                                        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 mt-3">
                                            <h5>Capacity</h5>
                                            <p>{{ $room->capacity }}</p>
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
                            <h5 class="mb-0">Room Images</h5>
                        </div>
                        <div class="card-body">
                            @if ($media->isEmpty())
                                <p class="text-muted text-center mb-0">No images uploaded for this room.</p>
                            @else
                                <div class="row">
                                    @foreach ($media as $image)
                                        <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                                            <div class="image-container shadow-sm">
                                                <img src="{{ $image['url'] }}" class="img-fluid rounded" alt="Room Image">
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
