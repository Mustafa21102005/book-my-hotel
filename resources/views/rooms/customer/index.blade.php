@extends('layouts.app')

@section('title', 'Rooms')

@section('content')
    <div class="thmv-room-headv2">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="thmv-subpage-titlev2">
                        <h2 class="text-uppercase">
                            {{ $hotelData ? $hotelData->name . ' Rooms' : 'Rooms' }}
                        </h2>
                        <p>
                            Discover a selection of beautifully designed rooms and <br> suites crafted for comfort and
                            relaxation.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="thmv-room-listv2-sec thmv-two-col-roomlist-v1">
        <div class="container">
            <div class="row">
                <div class="col-xl-8 col-lg-7">

                    {{-- NO RESULTS --}}
                    @if ($rooms->count() === 0)
                        <div class="alert alert-warning text-center mt-4">
                            No rooms found! Try adjusting your search filters
                            <img src="https://fonts.gstatic.com/s/e/notoemoji/latest/1f636_200d_1f32b_fe0f/512.gif"
                                width="34">
                        </div>
                    @else
                        @foreach ($rooms as $room)
                            @php
                                $promo = $room->hotel->activePromotion();
                            @endphp

                            {{-- OPEN ROW every 2 items --}}
                            @if ($loop->iteration % 2 == 1)
                                <div class="row">
                            @endif

                            <div class="thmv-list-box col-lg-6 col-md-6 col-sm-12 col-12">
                                <div class="thmv-listimg">

                                    {{-- Room Image --}}
                                    <img class="img-fluid" src="{{ $room->getFirstMediaUrl('room-img') }}">

                                    @if ($promo)
                                        <div
                                            style="position:absolute; top:10px; left:10px; background:#ff4444; color:white; padding:5px 10px; border-radius:4px; font-weight:bold;">
                                            -{{ $promo->discount_percent }}% OFF
                                        </div>
                                    @endif

                                    <div class="thmv-listimg-from">
                                        @if ($promo)
                                            <h4 class="thmv-bg-glass">
                                                <span style="text-decoration: line-through; color:#685656; font-size:14px;">
                                                    AED {{ number_format($room->price, 2) }}
                                                </span>
                                                <br>
                                                <span style="font-weight:bold;">
                                                    AED
                                                    {{ number_format($room->price * (1 - $promo->discount_percent / 100), 2) }}
                                                </span>
                                            </h4>
                                        @else
                                            <h4 class="thmv-bg-glass">AED {{ number_format($room->price, 2) }}</h4>
                                        @endif
                                    </div>
                                </div>

                                <div class="thmv-listroom-info d-flex justify-content-between align-items-center">
                                    <p class="thmv-queenbed">For {{ $room->capacity }} <i class="ph ph-person"></i>,
                                        {{ ucfirst($room->type) }}</p>

                                    <ul class="thmv-listroom-servicec d-flex justify-content-end">
                                        @if ($room->hotel->pool)
                                            <li>
                                                <i class="ph ph-swimming-pool med-icon"></i>
                                            </li>
                                        @endif

                                        @if ($room->hotel->wifi)
                                            <li>
                                                <i class="ph ph-wifi-high med-icon"></i>
                                            </li>
                                        @endif

                                        @if ($room->hotel->breakfast)
                                            <li>
                                                <i class="ph ph-fork-knife med-icon"></i>
                                            </li>
                                        @endif

                                        @if ($room->hotel->gym)
                                            <li>
                                                <i class="ph ph-barbell med-icon"></i>
                                            </li>
                                        @endif

                                        @if ($room->hotel->pets_allowed)
                                            <li>
                                                <i class="ph ph-paw-print med-icon"></i>
                                            </li>
                                        @endif

                                        @if ($room->hotel->environment)
                                            <li>
                                                <i class="ph ph-leaf med-icon"></i>
                                            </li>
                                        @endif
                                    </ul>
                                </div>

                                <div class="thmv-listroom-detail">
                                    <h5>{{ $room->name }}</h5>
                                    <p>{{ Str::limit($room->description, 120) }}</p>
                                    <a class="read-more-btn" href="{{ route('customer.rooms.show', $room->id) }}">
                                        View More Details <i class="fas fa-plus"></i>
                                    </a>
                                </div>
                            </div>

                            {{-- CLOSE ROW every 2 items OR last item --}}
                            @if ($loop->iteration % 2 == 0 || $loop->last)
                </div>
                @endif
                @endforeach

                @endif

                <x-pagination :paginator="$rooms" />
            </div>
            <div class="col-xl-4 col-lg-5 d-none d-lg-block">
                <div class="thmv-checkavai-form mt-0">
                    <div class="thmv-form-availability">
                        <h5>Filter Rooms</h5>
                    </div>

                    <form class="thmv-availability-check" action="{{ route('customer.rooms.index') }}" method="GET">
                        <div class="thmv-mo-check-form">
                            <div class="form-group">
                                <input type="number" class="form-control" placeholder="Minimum Price" name="price_min"
                                    min="0" step="0.10">
                            </div>

                            <div class="form-group">
                                <input type="number" name="price_max" class="form-control" placeholder="Maximum Price"
                                    min="0" step="0.10">
                            </div>

                            <div class="form-group mb-3">
                                <select name="type" class="form-select">
                                    <option selected disabled>Select Room Type</option>
                                    <option value="standard" {{ request('type') == 'standard' ? 'selected' : '' }}>Standard
                                    </option>
                                    <option value="deluxe" {{ request('type') == 'deluxe' ? 'selected' : '' }}>Deluxe
                                    </option>
                                    <option value="suite" {{ request('type') == 'suite' ? 'selected' : '' }}>Suite
                                    </option>
                                </select>
                            </div>
                        </div>

                        <div class="dropdown form-select-guests thmv-mo-guest-col">
                            <div class="form-group">
                                <div class="form-content dropdown-toggle" data-toggle="dropdown">
                                    <div class="wrapper-more">
                                        <div class="render">
                                            <span class="adults"><span class="one d-none">2 Adults</span>
                                                <span class="multi" data-html=":count Adults">2
                                                    Adults</span></span>
                                            <i class="fas fa-user-friends thmv-peoples-icon"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="dropdown-menu select-guests-dropdown"
                                    style="display: none; position: absolute; transform: translate3d(5px, 82px, 0px); top: 0px; left: 0px; will-change: transform;">
                                    <input type="hidden" name="adults" min="1" value="2">
                                    <div class="dropdown-item-row">
                                        <div class="label">Adults</div>
                                        <div class="val">
                                            <span class="btn-minus" data-input="adults"><i class="fas fa-minus"></i></span>
                                            <span class="count-display">2</span>
                                            <span class="btn-add" data-input="adults"><i class="fas fa-plus"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="thmv-extra-services">
                            <ul class="thmv-extra-services-list">
                                <li>
                                    <div class="thmv-services-checkbox">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="1"
                                                name="promotion_only" id="promotion"
                                                {{ request('promotion_only') ? 'checked' : '' }}>
                                            <label class="form-check-label" for="promotion">
                                                Show Hotels on Promotion
                                            </label>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                            <hr class="thmv-separate">
                        </div>

                        <div class="form-group">
                            <button class="thmv-tour-search btn-full-filled" type="submit">Filter</button>
                        </div>
                        @if (request()->query())
                            <div class="thmv-criteria_info text-center">
                                <a href="{{ route('customer.rooms.index') }}">Clear Filters</a>
                            </div>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
