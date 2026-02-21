@extends('layouts.app')

@section('title', 'Room')

@section('css')
    <style>
        .big-icon {
            font-size: 1.5rem;
        }

        #applyDiscount {
            height: calc(2.25em + 0.75rem + 2px);
            /* matches .form-control height */
            padding: 0.375rem 0.75rem;
            /* default button padding */
            border-top-left-radius: 0;
            border-bottom-left-radius: 0;
        }
    </style>
@endsection

@section('content')
    <div class="thmv-header-room-single-v1 container-fluid">
        <div class="row">
            <div class="thmv-header-slick slider">
                @php
                    $promo = $room->hotel->activePromotion();
                @endphp

                @foreach ($room->getMedia('room-img') as $image)
                    <div style="position: relative;">
                        <img src="{{ $image->getUrl() }}">

                        @if ($promo)
                            <div
                                style="position:absolute; top:10px; left:10px; background:#ff4444; color:white; padding:5px 12px; border-radius:4px; font-weight:bold;z-index:10;">
                                -{{ $promo->discount_percent }}% OFF
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="thmv-room-single">
        <div class="container">
            <div class="row">
                <div class="col-xl-8 col-lg-7 thmv-room-details">
                    <div class="thmv-Signature-title">
                        <p><i class="fas fa-star"></i> <strong>{{ $averageRating }}</strong> ({{ $reviewsCount }})</p>
                        <h2>{{ $room->name }}</h2>
                    </div>
                    <hr class="thmv-separate">
                    <p class="thmv-room-single-info-text">
                    <h5>{{ $room->hotel->name }} <span>({{ $room->hotel->region }})</span></h5>
                    {{ $room->hotel->description }}
                    </p>
                    <hr class="thmv-separate">
                    <div class="thmv-single-services thmv-nearby-us">
                        <ul>
                            <li>
                                <div class="thmv-nearby-icon" style="width: 50px; height: 50px; margin-bottom: 10px;">
                                    <img src="{{ asset('template/images/icons/guests.svg') }}">
                                </div>
                                @php
                                    if ($room->capacity == 1) {
                                        $desc = 'Ideal for solo travelers.';
                                    } elseif ($room->capacity == 2) {
                                        $desc = 'Perfect for couples.';
                                    } else {
                                        $desc = 'Great for groups trips or family vacations.';
                                    }
                                @endphp

                                <div class="thmv-nearby-places">
                                    <h6>{{ $room->capacity }} {{ Str::plural('guest', $room->capacity) }}</h6>
                                    <p>{{ $desc }}</p>
                                </div>
                            </li>
                            <li>
                                <div class="thmv-nearby-icon" style="width: 50px; height: 50px; margin-bottom: 10px;">
                                    <img src="{{ asset('template/images/icons/sofa.svg') }}">
                                </div>
                                <div class="thmv-nearby-places">
                                    <h6>
                                        @php
                                            $types = [
                                                'standard' => 'Standard Room',
                                                'deluxe' => 'Deluxe Room',
                                                'suite' => 'Suite',
                                            ];
                                            $typeText = [
                                                'standard' => 'Comfortable stays for everyone.',
                                                'deluxe' => 'Premium experience with extra amenities.',
                                                'suite' => 'Luxury suites for an unforgettable stay.',
                                            ];
                                        @endphp
                                        {{ $types[$room->type] ?? ucfirst($room->type) }}
                                    </h6>
                                    <p>{{ $typeText[$room->type] ?? 'Perfect for a relaxing stay.' }}</p>
                                </div>
                            </li>
                            <li>
                                <div class="thmv-nearby-icon" style="width: 50px; height: 50px; margin-bottom: 10px;">
                                    <img src="{{ asset('template/images/icons/calendar.svg') }}">
                                </div>
                                <div class="thmv-nearby-places">
                                    <h6><a target="_blank" href="{{ route('cancellation') }}">Cancellation policy</a></h6>
                                    <p>Please check our cancellation policy before booking.</p>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <hr class="thmv-separate">
                    <div class="thmv-amenities">
                        <h5>amenities</h5>
                        <div class="thmv-amenities-services">
                            <div class="thmv-amenities-col">
                                <div class="thmv-single-services thmv-nearby-us">
                                    <ul>
                                        @if ($room->hotel->pool)
                                            <li class="d-flex align-items-center">
                                                <div class="thmv-nearby-icon d-flex align-items-center justify-content-center bg-light rounded"
                                                    style="width: 50px; height: 50px; margin-bottom: 15px; margin-right: 15px;">
                                                    <i class="ph ph-swimming-pool big-icon fs-4"></i>
                                                </div>
                                                <div class="thmv-nearby-places">
                                                    <p>Swimming Pool</p>
                                                </div>
                                            </li>
                                        @endif

                                        @if ($room->hotel->wifi)
                                            <li class="d-flex align-items-center">
                                                <div class="thmv-nearby-icon d-flex align-items-center justify-content-center bg-light rounded"
                                                    style="width: 50px; height: 50px; margin-right: 15px; margin-bottom: 15px;">
                                                    <i class="ph ph-wifi-high big-icon fs-4"></i>
                                                </div>
                                                <div class="thmv-nearby-places">
                                                    <p>Free Wifi</p>
                                                </div>
                                            </li>
                                        @endif

                                        @if ($room->hotel->breakfast)
                                            <li class="d-flex align-items-center">
                                                <div class="thmv-nearby-icon d-flex align-items-center justify-content-center bg-light rounded"
                                                    style="width: 50px; height: 50px; margin-bottom: 15px; margin-right: 15px;">
                                                    <i class="ph ph-fork-knife big-icon fs-4"></i>
                                                </div>
                                                <div class="thmv-nearby-places">
                                                    <p>Breakfast</p>
                                                </div>
                                            </li>
                                        @endif
                                    </ul>
                                </div>
                            </div>
                            <div class="thmv-amenities-col">
                                <div class="thmv-single-services thmv-nearby-us">
                                    <ul>
                                        @if ($room->hotel->gym)
                                            <li class="d-flex align-items-center">
                                                <div class="thmv-nearby-icon d-flex align-items-center justify-content-center bg-light rounded"
                                                    style="width: 50px; height: 50px; margin-bottom: 15px; margin-right: 15px;">
                                                    <i class="ph ph-barbell big-icon fs-4"></i>
                                                </div>
                                                <div class="thmv-nearby-places">
                                                    <p>Gym</p>
                                                </div>
                                            </li>
                                        @endif

                                        @if ($room->hotel->pets_allowed)
                                            <li class="d-flex align-items-center">
                                                <div class="thmv-nearby-icon d-flex align-items-center justify-content-center bg-light rounded"
                                                    style="width: 50px; height: 50px; margin-right: 15px; margin-bottom: 15px;">
                                                    <i class="ph ph-paw-print big-icon fs-4"></i>
                                                </div>
                                                <div class="thmv-nearby-places">
                                                    <p>Pets Allowed</p>
                                                </div>
                                            </li>
                                        @endif

                                        @if ($room->hotel->environment)
                                            <li class="d-flex align-items-center">
                                                <div class="thmv-nearby-icon bg-light rounded"
                                                    style="width: 50px; height: 50px; margin-bottom: 15px; margin-right: 15px;">
                                                    <i class="ph ph-leaf big-icon fs-4"></i>
                                                </div>
                                                <div class="thmv-nearby-places">
                                                    <p>Eco-friendly</p>
                                                </div>
                                            </li>
                                        @endif
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr class="thmv-separate">
                    <div class="thmv-price row">
                        <h5>Price</h5>
                        <div class="thmv-price-details col-md-3 col-6">
                            <h5>Per Night</h5>
                            @if ($promo)
                                {{-- OLD Price --}}
                                <p style="text-decoration: line-through; color:#ff4444; margin-bottom:4px;">
                                    AED {{ number_format($room->price, 2) }}
                                </p>

                                {{-- DISCOUNTED Price --}}
                                <p style="font-weight:bold;">
                                    AED {{ number_format($room->price * (1 - $promo->discount_percent / 100), 2) }}
                                </p>

                                {{-- Savings --}}
                                <small class="text-success">
                                    You save AED {{ number_format($room->price * ($promo->discount_percent / 100), 2) }}!
                                </small>
                            @else
                                <p>AED {{ number_format($room->price, 2) }}</p>
                            @endif
                        </div>
                    </div>
                    <hr class="thmv-separate">
                    <div class="thmv-availability row align-items-center">
                        <h5>Availability</h5>
                        <div class="col-md-7 col-12">
                            <div id="bookedDates" class="thmv-availability-datepik"></div>
                        </div>
                        <div class="col-md-5 col-12">
                            <div class="thmv-single-services thmv-nearby-us">
                                <ul>
                                    <li>
                                        <div class="thmv-nearby-icon">
                                            <img src="{{ asset('template/images/date-pik/selected-date.svg') }}">
                                        </div>
                                        <div class="thmv-nearby-places">
                                            <h6>Selected Dates</h6>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="thmv-nearby-icon">
                                            <img src="{{ asset('template/images/date-pik/available-room.svg') }}">
                                        </div>
                                        <div class="thmv-nearby-places">
                                            <h6>Available Room</h6>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="thmv-nearby-icon">
                                            <img src="{{ asset('template/images/date-pik/no-available-room.svg') }}">
                                        </div>
                                        <div class="thmv-nearby-places">
                                            <h6>No Available Room</h6>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <hr class="thmv-separate">
                    <div class="thmv-reviews-sec">
                        <h5>Hotel Reviews</h5>
                        <div class="row thmv-review-row align-items-center">
                            <div class="col-md-3 col-12 thmv-rating-col">
                                <div class="thmv-all-rating">
                                    <div class="thmv-rating-title d-flex align-items-center">
                                        <i class="fas fa-star"></i>
                                        <h2>{{ $averageRating }}</h2>
                                    </div>
                                    <p class="thmv-p-light">Based on {{ $reviewsCount }} reviews</p>
                                </div>
                            </div>
                            <div class="col-md-9 col-12 thmv-progress-sec">
                                <ul>
                                    <li>
                                        <div class="thmv-progtess-info">
                                            <h6>Positive</h6>
                                            <p class="thmv-p-light">4 stars and above</p>
                                        </div>
                                        <div class="thmv-progress">
                                            <h5>{{ $positivePercent }}%</h5>
                                            <div class="progress">
                                                <div class="progress-bar" role="progressbar"
                                                    style="width: {{ $positivePercent }}%"
                                                    aria-valuenow="{{ $positivePercent }}" aria-valuemin="0"
                                                    aria-valuemax="100"></div>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="thmv-progtess-info">
                                            <h6>Neutral</h6>
                                            <p class="thmv-p-light">3 stars only</p>
                                        </div>
                                        <div class="thmv-progress">
                                            <h5>{{ $neutralPercent }}%</h5>
                                            <div class="progress">
                                                <div class="progress-bar" role="progressbar"
                                                    style="width: {{ $neutralPercent }}%"
                                                    aria-valuenow="{{ $neutralPercent }}" aria-valuemin="0"
                                                    aria-valuemax="100"></div>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="thmv-progtess-info">
                                            <h6>Negative</h6>
                                            <p class="thmv-p-light mb-0">Under 2 stars</p>
                                        </div>
                                        <div class="thmv-progress">
                                            <h5>{{ $negativePercent }}%</h5>
                                            <div class="progress">
                                                <div class="progress-bar" role="progressbar"
                                                    style="width: {{ $negativePercent }}%"
                                                    aria-valuenow="{{ $negativePercent }}" aria-valuemin="0"
                                                    aria-valuemax="100"></div>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div id="reviews-container">
                            @include('rooms.partials.reviews', ['reviews' => $reviews])
                        </div>
                    </div>
                </div>

                <div class="col-xl-4 col-lg-5 col-md-12 thmv-side-bar">
                    <div class="thmv-side-bar-sticky">
                        <div class="mt-0 thmv-checkavai-form">
                            <div class="thmv-form-availability">
                                <h5>Your Booking</h5>
                            </div>
                            <form class="thmv-availability-check" id="bookingForm"
                                action="{{ route('bookings.prepare') }}" method="POST">
                                @csrf

                                <input type="hidden" name="room_id" value="{{ $room->id }}">
                                <input type="hidden" name="check_in" id="check_in">
                                <input type="hidden" name="check_out" id="check_out">
                                <input type="hidden" name="discount_percent" id="discount_percent">

                                <div class="thmv-mo-check-form">
                                    <div class="form-group">
                                        <input type="text" class="form-control check-in-out" id="display_check_in"
                                            placeholder="Check-in Date" readonly>
                                        <i class="fas fa-calendar-day"></i>
                                    </div>

                                    <div class="form-group">
                                        <input type="text" class="form-control check-in-out" id="display_check_out"
                                            placeholder="Check-out Date" readonly>
                                        <i class="fas fa-calendar-day"></i>
                                    </div>

                                    <div class="form-group" id="discountContainer" style="display: none;">
                                        <label for="discount_code">Discount Code</label>
                                        <div class="input-group mb-3" style="max-width: 400px; align-items: stretch;">
                                            <input type="text" class="form-control" id="discount_code"
                                                placeholder="Enter discount code">
                                            <button class="btn btn-outline-dark" type="button"
                                                id="applyDiscount">Apply</button>
                                        </div>
                                        <small id="discountMessage" class="form-text text-success"></small>
                                    </div>
                                </div>

                                <div class="thmv-extra-services">
                                    <hr class="thmv-separate">
                                    <div class="thmv-your-price">
                                        <h5>Price :</h5>
                                        <h5 id="totalPrice">AED 0</h5>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <button class="thmv-tour-search btn-full-filled" type="submit">
                                        Book Now
                                    </button>
                                </div>
                            </form>
                        </div>

                        <div class="thmv-discount">
                            <img src="{{ asset('template/images/get-discount.jpg') }}">
                            <a href="{{ route('customer.discounts.index') }}"
                                class="btn-full-filled-light text-capitalize">
                                Get a discount
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        document.addEventListener("DOMContentLoaded", function() {

            /* ===============================
               Reviews AJAX Pagination
            ================================ */
            const container = document.getElementById('reviews-container');

            container?.addEventListener('click', function(e) {
                const link = e.target.closest('a.page-link');
                if (!link) return;

                e.preventDefault();

                fetch(link.href, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => response.text())
                    .then(html => {
                        container.innerHTML = html;
                        container.scrollIntoView({
                            behavior: 'smooth'
                        });
                    })
                    .catch(err => console.error(err));
            });

            let basePrice = 0;
            let discountAmount = 0;
            let discountPercent = 0; // store the last valid discount %

            /* ===============================
               Apply Discount Code
            ================================ */
            $('#applyDiscount').on('click', function() {
                const code = $('#discount_code').val();

                if (!code) {
                    alert('Please enter a discount code.');
                    return;
                }

                // Open modal
                const modal = new bootstrap.Modal(document.getElementById('confirmDiscountModal'));
                modal.show();
            });

            $('#confirmApplyDiscount').on('click', async function() {
                const code = $('#discount_code').val();
                const modalEl = document.getElementById('confirmDiscountModal');
                const modal = bootstrap.Modal.getInstance(modalEl);
                const discountValidateUrl = "{{ route('discounts.validate') }}";
                modal.hide();

                try {
                    const response = await fetch(discountValidateUrl, {
                        method: "POST",
                        headers: {
                            "X-CSRF-TOKEN": "{{ csrf_token() }}",
                            "Content-Type": "application/json",
                        },
                        body: JSON.stringify({
                            code
                        })
                    });

                    const data = await response.json();

                    // Validation error (422)
                    if (response.status === 422) {
                        const errorMessage = data.errors?.code?.[0] ?? 'Invalid input.';
                        $('#discountMessage')
                            .text(errorMessage)
                            .removeClass('text-success')
                            .addClass('text-danger');
                        return;
                    }

                    if (!response.ok) {
                        $('#discountMessage')
                            .text(data.message || 'Error validating discount code.')
                            .removeClass('text-success')
                            .addClass('text-danger');
                        return;
                    }

                    // Success (200)
                    if (data.valid) {
                        discountPercent = data.discount_percent;
                        const newTotal = basePrice * (1 - discountPercent / 100);

                        $('#totalPrice').text(`AED ${newTotal.toFixed(2)}`);
                        $('#discountMessage')
                            .text(`Discount applied: ${discountPercent}% off`)
                            .removeClass('text-danger')
                            .addClass('text-success');
                    } else {
                        discountPercent = 0;
                        $('#totalPrice').text(`AED ${basePrice.toFixed(2)}`);
                        $('#discountMessage')
                            .text(data.message || 'Invalid code!')
                            .removeClass('text-success')
                            .addClass('text-danger');
                    }

                } catch (err) {
                    console.error(err);
                    $('#discountMessage')
                        .text('Server error while validating discount code.')
                        .removeClass('text-success')
                        .addClass('text-danger');
                }
            });

            /* ===============================
               Unavailable Dates Generator
            ================================ */
            const bookedDates = @json($bookedDates);
            const unavailableDates = [];

            bookedDates.forEach(range => {
                let current = new Date(range.start);
                const end = new Date(range.end);

                while (current <= end) {
                    unavailableDates.push(current.toISOString().split('T')[0]);
                    current.setDate(current.getDate() + 1);
                }
            });

            /* ===============================
               Date Picker + Price Calculator
            ================================ */
            let pricePerNight = {{ $promo ? $room->price * (1 - $promo->discount_percent / 100) : $room->price }};
            pricePerNight = Number(pricePerNight.toFixed(2));

            $('#bookedDates').datepick({
                monthsToShow: 1,
                monthsToStep: 1,
                rangeSelect: true,

                renderer: {
                    weekendClass: 'datepick-weekend thmv-date-weekendClass',
                    multiClass: 'thmv-date-multiClass',
                    defaultClass: 'thmv-date-defaultClass',
                    selectedClass: 'datepick-selected thmv-date-selectedClass',
                    highlightedClass: 'thmv-date-highlightedClass',
                    todayClass: 'datepick-today thmv-date-todayClass',
                    otherMonthClass: 'thmv-date-otherMonthClass',
                    disabledClass: 'thmv-date-disabledClass',
                },

                onDate: function(date) {
                    const dStr = date.toISOString().split('T')[0];
                    return {
                        selectable: !unavailableDates.includes(dStr)
                    };
                },

                onSelect: function(dates) {
                    if (dates.length !== 2) return;

                    const start = dates[0];
                    const end = dates[1];

                    const checkIn = start.toISOString().split('T')[0];
                    const checkOut = end.toISOString().split('T')[0];

                    $('#check_in').val(checkIn);
                    $('#check_out').val(checkOut);

                    $('#display_check_in').val(checkIn);
                    $('#display_check_out').val(checkOut);

                    const diffTime = end - start;
                    const days = Math.max(1, Math.ceil(diffTime / (1000 * 60 * 60 * 24)));

                    const total = days * pricePerNight;
                    basePrice = total;

                    // Apply discount if any
                    const finalTotal = discountPercent > 0 ? basePrice * (1 - discountPercent / 100) :
                        basePrice;
                    $('#totalPrice').text('AED ' + finalTotal.toFixed(2));

                    $('#discountContainer').fadeIn();
                }
            });

            /* ===============================
               Booking Form Submission
            ================================ */
            $('#bookingForm').on('submit', function(e) {
                $('#discount_percent').val(discountPercent);

                const checkIn = $('#check_in').val();
                const checkOut = $('#check_out').val();

                if (!checkIn || !checkOut) {
                    alert('Please select your dates first.');
                    return;
                }

                fetch("{{ route('bookings.prepare') }}", {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": "{{ csrf_token() }}",
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify({
                        room_id: {{ $room->id }},
                        check_in: checkIn,
                        check_out: checkOut,
                        discount_percent: discountPercent,
                        discount_code: $('#discount_code').val()
                    })
                }).then(() => {
                    window.location.href = "{{ route('bookings.checkout', $room->id) }}";
                });
            });

        });
    </script>

@endsection
