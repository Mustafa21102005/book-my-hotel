<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    {{-- CSRF Token --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>BMH | @yield('title')</title>

    {{-- Favicon Icon --}}
    <link rel="icon" type="image/png" href="{{ asset('auth/favicon/favicon-96x96.png') }}" sizes="96x96" />
    <link rel="icon" type="image/svg+xml" href="{{ asset('auth/favicon/favicon.svg') }}" />
    <link rel="shortcut icon" href="{{ asset('auth/favicon/favicon.ico') }}" />
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('auth/favicon/apple-touch-icon.png') }}" />
    <link rel="manifest" href="{{ asset('auth/favicon/site.webmanifest') }}" />

    {{-- Google fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Trirong:wght@100;200;300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">

    {{-- Font-Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    {{-- Datepick CSS --}}
    <link rel="stylesheet" href="{{ asset('template/plugin/datepick/css/jquery.datepick.css') }}">

    {{-- Bootstrap CSS --}}
    <link rel="stylesheet" href="{{ asset('template/css/bootstrap.min.css') }}">

    {{-- Slick Slider CSS --}}
    <link rel="stylesheet" href="{{ asset('template/plugin/slick/css/slick-theme.css') }}">
    <link rel="stylesheet" href="{{ asset('template/plugin/slick/css/slick.css') }}">

    {{-- Style CSS --}}
    <link rel="stylesheet" href="{{ asset('template/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('template/css/responsive.css') }}">

    {{-- jQuery JS --}}
    <script src="{{ asset('template/js/jquery-3.6.0.min.js') }}"></script>

    {{-- Datepick JS --}}
    <script src="{{ asset('template/plugin/datepick/js/jquery.plugin.min.js') }}"></script>
    <script src="{{ asset('template/plugin/datepick/js/jquery.datepick.js') }}"></script>

    {{-- Phosphor Icons --}}
    <link rel="stylesheet" type="text/css"
        href="https://cdn.jsdelivr.net/npm/@phosphor-icons/web@2.1.1/src/regular/style.css" />

    <style>
        .big-i {
            font-size: 3rem;
        }

        .med-icon {
            font-size: 1.5rem;
        }
    </style>

    @yield('css')
</head>

<body>
    <div class="thmv-top-nav">
        <nav id="navbar_top" class="navbar navbar-expand-sm fixed-top thmv-navbar-light ">
            <div class="container thmv-mob-nav">
                <div class="thmv-menu-left">
                    <a class="offcanvas-toggler" href="#offcanvasExample" role="button" data-bs-toggle="offcanvas"
                        data-bs-target="#offcanvasWithBothOptions">
                        <span class="navbar-toggler-icon"><i class="fas fa-bars"></i></span>
                    </a>
                </div>
                <button class="navbar-toggler d-none" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-end show" id="navbarSupportedContent">
                    <a class="navbar-brand mx-auto d-none d-md-block" href="{{ route('home') }}">
                        Book My Hotel
                    </a>
                    <div class="d-flex thmv-right-menu">
                        @guest
                            <ul class="thmv-social d-none d-lg-flex ms-5">
                                <li><a href="{{ route('login') }}">Login</a></li>
                                <li><a href="{{ route('register') }}">Register</a></li>
                            </ul>
                        @else
                            <ul class="thmv-social d-none d-lg-flex ms-5">
                                <li>
                                    <a href="#" data-bs-toggle="modal" data-bs-target="#logoutModal">
                                        Logout
                                    </a>
                                </li>
                                <a class="btn-outline" href="{{ route('dashboard') }}">Dashboard</a>
                            </ul>
                        @endguest
                    </div>
                </div>
            </div>
        </nav>

        <div class="offcanvas offcanvas-start" data-bs-scroll="true" tabindex="-1" id="offcanvasWithBothOptions">
            <div class="thmv-offcanvas-header">
                <a href="javascript:void(0)" title="" class="thmv-menu-officon" data-bs-dismiss="offcanvas"
                    aria-label="Close"><i class="fas fa-times"></i></a>
                <h5 class="thmv-offcanvas-title" id="offcanvasExampleLabel">Book My Hotel</h5>
            </div>
            <div class="offcanvas-body thmv-offcanvas-body">
                <div class="thmv-leftside-menu">
                    <nav id="cd-lateral-nav">
                        <ul class="cd-navigation">
                            <li>
                                <a class="{{ Route::currentRouteName() == 'home' ? 'active' : '' }}"
                                    href="{{ route('home') }}">
                                    Home
                                </a>
                            </li>
                            <li>
                                <a class="{{ Route::currentRouteName() == 'customer.hotels.index' ? 'active' : '' }}"
                                    href="{{ route('customer.hotels.index') }}">
                                    Hotels
                                </a>
                            </li>
                            <li>
                                <a class="{{ Route::currentRouteName() == 'customer.rooms.index' ? 'active' : '' }}"
                                    href="{{ route('customer.rooms.index') }}">
                                    Rooms
                                </a>
                            </li>
                            <li>
                                <a class="{{ Route::currentRouteName() == 'customer.discounts.index' ? 'active' : '' }}"
                                    href="{{ route('customer.discounts.index') }}">
                                    Discount Codes
                                </a>
                            </li>
                            @guest
                                <li><a href="{{ route('login') }}">Login</a></li>
                                <li><a href="{{ route('register') }}">Register</a></li>
                            @else
                                <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            @endguest
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    @yield('content')

    {{-- Footer section start --}}
    <section class="thmv-footer">
        <div class="container-fluid">
            <div class="row thmv-footer-sec">
                <div class="container">
                    <div class="row align-items-top">
                        <div class="col-lg-4 thmv-about">
                            <h6>About Us</h6>
                            <p>
                                BookMyHotel helps you find and book eco-friendly and top-rated hotels worldwide. Earn
                                rewards, save on stays, and enjoy hassle-free travel planning.
                            </p>
                        </div>
                        <div class="col-lg-6 thmv-footer-menu">
                            <ul>
                                <li><a href="{{ route('home') }}">Home</a></li>
                                <li><a href="{{ route('customer.hotels.index') }}">Hotels</a></li>
                                <li><a href="{{ route('customer.rooms.index') }}">Rooms</a></li>
                            </ul>
                            <ul>
                                <li><a href="{{ route('privacy') }}">Privacy & Policy</a></li>
                                <li><a href="{{ route('cancellation') }}">Cancellation Policy</a></li>
                                <li><a href="{{ route('customer.discounts.index') }}">Discount Codes</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row thmv-bg-dark">
                <div class="container">
                    <div class="row thmv-bottom-footer ">
                        <div class="col-lg-4 col-md-4 col-sm-12 text-center text-md-start thmv-footer-bottom-menu">
                            <a href="{{ route('cancellation') }}" target="_blank">Cancellation Policy</a>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-12 text-center thmv-copyright">
                            <a href="#">&copy; Book My Hotel. All right reserved.</a>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-12 text-center text-md-end">
                            <ul class="d-flex thmv-payment justify-content-center justify-content-md-end">
                                <li>
                                    <button><i class="fab fa-cc-visa"></i></button>
                                </li>
                                <li>
                                    <button><i class="fab fa-cc-paypal"></i></button>
                                </li>
                                <li>
                                    <button><i class="fab fa-cc-mastercard"></i></button>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    {{-- Footer section End --}}

    {{-- Logout Confirmation Modal --}}
    <div class="modal fade book_popup" id="logoutModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                {{-- Header --}}
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                {{-- Body --}}
                <div class="modal-body">
                    <div class="modal_form_title">
                        <h4>Are Yout Sure You Want To Logout?</h4>
                    </div>
                </div>

                {{-- Footer / Buttons --}}
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn-outline-light" data-bs-dismiss="modal">
                        Cancel
                    </button>
                    <a href="{{ route('logout') }}" class="btn-outline-light"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        Logout
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Discount Confirmation Modal --}}
    <div class="modal fade" id="confirmDiscountModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Apply Discount?</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    Applying this discount code is permanent.
                    You cannot remove it after applying.
                    Are you sure you want to apply this code?
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button class="btn btn-dark" id="confirmApplyDiscount">Apply Discount</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Right side floting buttons --}}
    <div class="thmv-home-side thmv-home-floting-btn">
        <a href="" id="home-top" class="thmv-backto-top-sticky">
            <i class="fas fa-chevron-up"></i>Go to top
        </a>
    </div>

    {{-- bootstrap JS --}}
    <script src="{{ asset('template/js/bootstrap.min.js') }}"></script>

    {{-- Slick Slider JS --}}
    <script src="{{ asset('template/plugin/slick/js/slick.min.js') }}"></script>

    {{-- custom JS --}}
    <script src="{{ asset('template/js/custom.js') }}"></script>

    @yield('js')
</body>

</html>
