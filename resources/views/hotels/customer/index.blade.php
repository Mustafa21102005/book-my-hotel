@extends('layouts.app')

@section('title', 'Hotels')

@section('css')
    <style>
        .big-icon {
            font-size: 1.6rem;
        }

        .facility-checkboxes {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 8px 12px;
            margin-top: 5px;
        }

        .facility-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 12px;
            border: 1px solid #ddd;
            border-radius: 6px;
            background: #f8f9fa;
            cursor: pointer;
            transition: 0.2s ease;
            font-size: 0.9rem;
            line-height: 1.2;
        }

        .facility-item:hover {
            background: #eef2f5;
            border-color: #c7c7c7;
        }

        .facility-item input[type="checkbox"] {
            width: 18px;
            height: 18px;
            accent-color: #0d6efd;
        }
    </style>
@endsection

@section('content')
    <div class="thmv-room-headv3">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="thmv-subpage-titlev3 text-center">
                        <h2>Hotels</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="thmv-room-listv2-sec">
        <div class="container">
            <div class="row">
                <div class="col-xl-8 col-lg-7">
                    {{-- NO RESULTS --}}
                    @if ($hotels->count() === 0)
                        <div class="alert alert-warning text-center mt-4">
                            No hotels found! Try adjusting your search filters
                            <img src="https://fonts.gstatic.com/s/e/notoemoji/latest/1f636_200d_1f32b_fe0f/512.gif"
                                width="34">
                        </div>
                    @else
                        @foreach ($hotels as $hotel)
                            <div class="thmv-list-box">
                                <div class="thmv-listimg">
                                    <img class="img-fluid" src="{{ $hotel->getFirstMediaUrl('hotel-img') }}">
                                </div>
                                <div class="thmv-listroom-info d-flex justify-content-between align-items-center">
                                    <p class="thmv-queenbed">{{ ucfirst($hotel->region) }}, {{ $hotel->country }},
                                        {{ $hotel->city }}</p>
                                    <ul class="thmv-listroom-servicec d-flex">
                                        @if ($hotel->pool)
                                            <li>
                                                <i class="ph ph-swimming-pool big-icon"></i>
                                            </li>
                                        @endif

                                        @if ($hotel->wifi)
                                            <li>
                                                <i class="ph ph-wifi-high big-icon"></i>
                                            </li>
                                        @endif

                                        @if ($hotel->breakfast)
                                            <li>
                                                <i class="ph ph-fork-knife big-icon"></i>
                                            </li>
                                        @endif

                                        @if ($hotel->gym)
                                            <li>
                                                <i class="ph ph-barbell big-icon"></i>
                                            </li>
                                        @endif

                                        @if ($hotel->pets_allowed)
                                            <li>
                                                <i class="ph ph-paw-print big-icon"></i>
                                            </li>
                                        @endif

                                        @if ($hotel->environment)
                                            <li>
                                                <i class="ph ph-leaf big-icon"></i>
                                            </li>
                                        @endif
                                    </ul>
                                </div>
                                <div class="thmv-listroom-detail">
                                    <h5>{{ $hotel->name }}</h5>
                                    <p>{{ $hotel->description }}</p>
                                    <a class="read-more-btn" href="{{ route('customer.rooms.index', $hotel->id) }}">Check
                                        Rooms
                                        <i class="fas fa-plus"></i>
                                    </a>
                                </div>
                            </div>
                        @endforeach

                        <x-pagination :paginator="$hotels" />
                    @endif
                </div>

                <div class="col-xl-4 col-lg-5 d-none d-lg-block">
                    <div class="thmv-checkavai-form mt-0">
                        <div class="thmv-form-availability">
                            <h5>Filter Hotels</h5>
                        </div>

                        <form class="thmv-availability-check" action="{{ route('customer.hotels.index') }}" method="GET">

                            <div class="thmv-mo-check-form">
                                {{-- Region --}}
                                <div class="form-group mb-3">
                                    <select name="region" class="form-select">
                                        <option selected disabled>Select Region</option>
                                        <option value="asia">Asia</option>
                                        <option value="europe">Europe</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <input type="text" name="country" class="form-control" placeholder="Country">
                                </div>

                                <div class="form-group">
                                    <input type="text" name="city" class="form-control" placeholder="City">
                                </div>

                                {{-- Rating --}}
                                <div class="form-group mb-3">
                                    <select name="rating" class="form-select">
                                        <option selected disabled>Select Rating</option>
                                        <option value="1">★ 1 Star</option>
                                        <option value="2">★ 2 Stars</option>
                                        <option value="3">★ 3 Stars</option>
                                        <option value="4">★ 4 Stars</option>
                                        <option value="5">★ 5 Stars</option>
                                    </select>
                                </div>

                                <div class="form-group mb-3">
                                    <label class="fw-bold mb-2 d-block">Amenities</label>

                                    <div class="facility-checkboxes">
                                        <label class="facility-item">
                                            <input type="checkbox" name="wifi" value="1">
                                            Wifi
                                        </label>

                                        <label class="facility-item">
                                            <input type="checkbox" name="pool" value="1">
                                            Pool
                                        </label>

                                        <label class="facility-item">
                                            <input type="checkbox" name="breakfast" value="1">
                                            Breakfast
                                        </label>

                                        <label class="facility-item">
                                            <input type="checkbox" name="gym" value="1">
                                            Gym
                                        </label>

                                        <label class="facility-item">
                                            <input type="checkbox" name="pets_allowed" value="1">
                                            Pets Allowed
                                        </label>

                                        <label class="facility-item">
                                            <input type="checkbox" name="environment" value="1">
                                            Eco-Friendly
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <button class="thmv-tour-search btn-full-filled" type="submit">Filter</button>
                            </div>
                            @if (request()->query())
                                <div class="thmv-criteria_info text-center">
                                    <a href="{{ route('customer.hotels.index') }}">Clear Filters</a>
                                </div>
                            @endif
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
