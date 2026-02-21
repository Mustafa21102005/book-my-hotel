@extends('layouts.app')

@section('title', 'Home')

@section('css')
    <style>
        .hotel-slide {
            position: relative;
            overflow: hidden;
        }

        .hotel-slide img {
            display: block;
            width: 100%;
            height: auto;
            transition: transform 0.3s ease;
        }

        .hotel-slide:hover img {
            transform: scale(1.1);
            /* subtle zoom on hover */
        }

        .hotel-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.3s ease;
            text-align: center;
            padding: 10px;
        }

        .hotel-slide:hover .hotel-overlay {
            opacity: 1;
        }

        .hotel-slide img {
            width: 100%;
            height: 400px;
        }
    </style>
@endsection

@section('content')
    <section class="thmv-main-banner">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-md-12 ">
                    <div class="thmv-banner-title thmv-bg-glass">
                        <h1>TRAVELLERS CHOICE <br>AWARD 2019</h1>
                        <p class="opacity-full">
                            Discover your perfect stay with <strong>BookMyHotel</strong> – your trusted platform for
                            booking hotels across Asia and Europe. Compare top hotels, enjoy eco-friendly options, and
                            earn rewards points for every sustainable booking. Seamless reservations, exclusive
                            promotions, and verified guest reviews make planning your trip easier than ever.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Booking Section Start --}}
    <div class="thmv-search-form border-bottom d-none d-lg-block">
        <div class="container">
            <div class="row">
                <form action="{{ route('customer.rooms.index') }}" method="GET" class="thmv-search-form-tour">
                    <div class="thmv-field-search">
                        <div class="row thmv-tour-row justify-content-center">

                            <div class="ps-0 col-lg-6 col-md-12 thmv-date-col">
                                <div class="thmv-check-form d-flex">
                                    <div class="form-group">
                                        <input type="number" class="form-control" placeholder="Minimum Price"
                                            name="price_min" min="0" step="0.10">
                                    </div>

                                    <div class="form-group">
                                        <input type="number" name="price_max" class="form-control" placeholder="Max Price"
                                            min="0" step="0.10">
                                    </div>
                                </div>
                            </div>

                            {{-- Guests --}}
                            <div class="col-lg-4 col-md-12 dropdown form-select-guests thmv-guest-col">
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
                                                <span class="btn-minus" data-input="adults"><i
                                                        class="fas fa-minus"></i></span>
                                                <span class="count-display">2</span>
                                                <span class="btn-add" data-input="adults"><i class="fas fa-plus"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-2 col-md-12 pe-0">
                                <div class="thmv-promo-box d-flex">
                                    <div class="form-group p-0">
                                        <button class="thmv-tour-search btn-full-filled border-0"
                                            type="submit">Search</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- Booking Section End --}}

    {{-- Facilities Section Start --}}
    <section class="thmv-facilities-sec">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6 col-12">
                    <div class="thmv-facilities-img">
                        <img src="{{ asset('template/images/facilities/residence-img.jpg') }}" alt="hotels"
                            title="Hotels">
                    </div>
                    <div class="thmv-facilities-info">
                        <h5>Hotels</h5>
                        <p class="thmv-p-light">
                            Browse and book from top hotels across Asia and Europe. Choose from luxurious rooms,
                            cozy suites, or eco-friendly stays—all verified for quality and comfort.
                        </p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-12">
                    <div class="thmv-facilities-img">
                        <img src="{{ asset('template/images/facilities/gastronomy-img.jpg') }}" alt="dining"
                            title="Dining">
                    </div>
                    <div class="thmv-facilities-info">
                        <h5>Dining & Cuisine</h5>
                        <p class="thmv-p-light">
                            Enjoy exquisite dining options with cuisine ranging from local specialties to
                            international gourmet experiences—all bookable through our platform.
                        </p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-12">
                    <div class="thmv-facilities-img">
                        <img src="{{ asset('template/images/facilities/wellness-spa-img.jpg') }}" alt="wellness-spa"
                            title="Wellness & Spa">
                    </div>
                    <div class="thmv-facilities-info">
                        <h5>Wellness & SPA</h5>
                        <p class="thmv-p-light">
                            Find hotels with relaxing spa and wellness centers. Earn sustainability rewards when you
                            choose eco-conscious wellness services.
                        </p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-12">
                    <div class="thmv-facilities-img">
                        <img src="{{ asset('template/images/facilities/events-img.jpg') }}" alt="events"
                            title="Events & Experiences">
                    </div>
                    <div class="thmv-facilities-info">
                        <h5>Events & Experiences</h5>
                        <p class="thmv-p-light">
                            Book special experiences, from guided tours to local events, directly with your hotel
                            reservation for a seamless travel experience.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    {{-- Facilities Section End --}}

    {{-- Our Hotel Section Start --}}
    <section class="thmv-our-hotel container-fluid">
        <div class="row">
            <div class="container">
                <div class="row">
                    <div class="thmv-sec-title text-center">
                        <h2 class="thmv-title-effect-center text-uppercase">Hotels</h2>
                    </div>
                    <div class="thmv-hotel-info w-75 mx-auto text-center">
                        <p>Discover our amazing hotels. Hover over any image to see the hotel name.</p>
                        <a class="read-more-btn" href="{{ route('customer.hotels.index') }}">
                            See More Hotels <i class="fas fa-plus"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row thmv-slick-img-slider">
            <div class="slick-image-center slider thmv-img-gray-hover">
                @foreach ($hotels as $hotel)
                    @php
                        $hotel_image = $hotel->getFirstMediaUrl('hotel-img');
                    @endphp
                    <div class="hotel-slide">
                        <img src="{{ $hotel_image }}" alt="{{ $hotel->name }}" class="img-fluid">
                        <div class="hotel-overlay">
                            <h4>{{ $hotel->name }}</h4>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    {{-- Our Hotel Section End --}}

    {{-- Welcome to BookMyHotel Section Start --}}
    <section class="thmv-welcome-sec thmv-bg-dark">
        <div class="container">
            <div class="row">
                <div class="col-lg-5 thmv-wel-text">
                    <h2 class="thmv-br-mob-none">Welcome to <br>BookMyHotel!</h2>
                </div>

                <div class="col-lg-6 offset-lg-1 thmv-wel-info">
                    <div class="thmv-paragraph">
                        <p class="mb-4">
                            Discover and book the most eco-friendly and luxurious hotels around the world. Earn
                            reward
                            points
                            for sustainable stays and redeem them for discounts on your next booking.
                        </p>
                        <p>
                            BookMyHotel makes your travel experience effortless and rewarding. Browse hotels, check
                            real
                            guest reviews, and secure your perfect stay in just a few clicks.
                        </p>
                    </div>
                    <div class="thmv-brand-logo">
                        <img src="{{ asset('template/images/brand-logo/travelweek-logo.png') }}" alt="">
                        <img src="{{ asset('template/images/brand-logo/tower-homes-logo.png') }}" alt="">
                        <img src="{{ asset('template/images/brand-logo/aero-logo.png') }}" alt="">
                    </div>
                </div>
            </div>
        </div>
    </section>
    {{-- Welcome to BookMyHotel section End --}}

    {{-- Rooms & Suites section start --}}
    <section class="thmv-rooms-suites container-fluid">
        <div class="row">
            <div class="container">
                <div class="row">
                    <div class="thmv-sec-title text-center">
                        <h2 class="thmv-title-effect-center text-uppercase">Rooms & Suites</h2>
                    </div>
                    <div class="thmv-rooms-info w-50 mx-auto text-center">
                        <p>Explore our collection of comfortable and stylish rooms,
                            each designed to offer a relaxing and memorable stay.</p>
                        <a class="read-more-btn" href="{{ route('customer.rooms.index') }}">
                            See More Rooms <i class="fas fa-plus"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row thmv-rooms-img-slider">
            <div class="slick-rooms-slider slider">
                @foreach ($rooms as $room)
                    @php
                        $room_image = $room->getFirstMediaUrl('room-img');
                    @endphp
                    <div class="thmv-img-gray-hover">
                        <div class="thmv-room-view position-relative">
                            <img src="{{ $room_image }}">

                            <div class="thmv-room-price thmv-bg-glass">
                                <p>AED {{ $room->price }}</p>
                            </div>
                        </div>

                        <div class="thmv-room-info">
                            <h5>{{ $room->name }}</h5>
                            <h6>For: {{ $room->capacity }} <i class="ph ph-person"></i></h6>
                            <h6>Hotel: {{ $room->hotel->name }}</h6>
                            <a class="read-more-btn" href="{{ route('customer.rooms.show', $room->id) }}">
                                Read More <i class="fas fa-plus"></i>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    {{-- Rooms & Suites section end --}}

    {{-- Important sec start --}}
    <section class="thmv-covid-sec">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-12">
                    <div class="thmv-about-covid">
                        <h2 class="thmv-br-mob-none">Cancellation <br>Policy</h2>
                        <p class="thmv-br-none">
                            At BookMyHotel, we offer flexible cancellation options to give you peace of mind when booking
                            your stay.
                            Learn how to manage, change, or cancel your reservations with ease.
                        </p>
                        <a class="read-more-btn" href="{{ route('cancellation') }}">
                            Read More <i class="fas fa-plus"></i>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="thmv-bg-dark thmv-rules-box h-100">
                        <div class="thmv-border-box h-100">
                            <h3 class="mb-3">Security</h3>
                            <p>
                                Your safety is our top priority. BookMyHotel uses secure systems to protect your personal
                                information,
                                ensure safe payments, and provide a trusted booking experience for every guest.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="thmv-promotions-box h-100">
                        <h3 class="mb-3">Promotions</h3>
                        <p>
                            Discover exclusive hotel room promotions on BookMyHotel that you won’t find on any other hotel
                            booking websites.
                            Enjoy special discounts and unbeatable deals across all our hotels.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    {{-- Important sec start --}}

    {{-- our service section start --}}
    <section class="thmv-our-service">
        <div class="row">
            <div class="container">
                <div class="row">
                    <div class="thmv-sec-title text-center">
                        <h2 class="thmv-title-effect-center text-uppercase">At Your Service</h2>
                    </div>
                    <div class="thmv-service-info w-50 w-md-75 mx-auto text-center">
                        <p>Enjoy a seamless stay at our hotels with amenities designed for comfort, convenience, and
                            relaxation.
                            From cozy rooms to premium services, we make every moment memorable.</p>
                    </div>
                </div>
                <div class="row thmv-services col-lg-12 mx-auto">
                    <ul>
                        <li>
                            <div class="thmv-services-box">
                                <i class="ph ph-wifi-high big-i"></i>
                                <p>Free WiFi</p>
                            </div>
                        </li>
                        <li>
                            <div class="thmv-services-box">
                                <i class="ph ph-swimming-pool big-i"></i>
                                <p>Swimming Pools</p>
                            </div>
                        </li>
                        <li>
                            <div class="thmv-services-box">
                                <i class="ph ph-paw-print big-i"></i>
                                <p>Pets Allowed</p>
                            </div>
                        </li>
                        <li>
                            <div class="thmv-services-box">
                                <i class="ph ph-fork-knife big-i"></i>
                                <p>Breakfast</p>
                            </div>
                        </li>
                        <li>
                            <div class="thmv-services-box">
                                <i class="ph ph-barbell big-i"></i>
                                <p>Gym</p>
                            </div>
                        </li>

                        <li>
                            <div class="thmv-services-box">
                                <i class="ph ph-leaf big-i"></i>
                                <p>Eco-Friendly</p>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="container">
                <hr class="thmv-ser-separator">
            </div>
        </div>
    </section>
    {{-- our service section end --}}

    {{-- review section start --}}
    <section class="thmv-review-sec">
        <div class="container">
            <div class="row">
                <div class="thmv-sec-title text-center">
                    <h2 class="thmv-title-effect-center text-uppercase">Reviews</h2>
                </div>
                <div class="thmv-review-info w-50 mx-auto text-center">
                    <p>
                        Discover what our guests are saying about their stays. At <strong>BookMyHotel</strong>, we
                        pride ourselves on providing exceptional experiences, and our reviews reflect the comfort, service,
                        and amenities that travelers value the most. Read honest feedback from fellow guests and make your
                        next stay unforgettable.
                    </p>
                </div>
            </div>
            <div class="row thmv-service">
                @foreach ($reviews as $review)
                    <div class="col-lg-4 col-md-6">
                        <div class="thmv-service-box">
                            <div class="thmv-rating">
                                <ul class="d-flex justify-content-center">
                                    @for ($i = 0; $i < $review->rating; $i++)
                                        <li><i class="fas fa-star"></i></li>
                                    @endfor

                                    @for ($i = $review->rating; $i < 5; $i++)
                                        <li><i class="far fa-star"></i></li>
                                    @endfor
                                </ul>
                                <p class="thmv-service-text">
                                    {{ $review->comment }}
                                </p>
                            </div>
                            <div class="thmv-user-info thmv-bg-dark text-center">
                                <h6>{{ $review->user->name }}</h6>
                                <p> {{ $review->created_at->diffForHumans() }}
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    {{-- review section end --}}
@endsection
