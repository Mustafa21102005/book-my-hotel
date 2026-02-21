<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="icon" type="image/png" href="{{ asset('auth/favicon/favicon-96x96.png') }}" sizes="96x96" />
    <link rel="icon" type="image/svg+xml" href="{{ asset('auth/favicon/favicon.svg') }}" />
    <link rel="shortcut icon" href="{{ asset('auth/favicon/favicon.ico') }}" />
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('auth/favicon/apple-touch-icon.png') }}" />
    <link rel="manifest" href="{{ asset('auth/favicon/site.webmanifest') }}" />

    <link rel="stylesheet" href="{{ asset('dashboard/vendor/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard/vendor/fonts/circular-std/style.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard/libs/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard/vendor/charts/chartist-bundle/chartist.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard/vendor/charts/morris-bundle/morris.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard/vendor/charts/c3charts/c3.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard/vendor/fonts/flag-icon-css/flag-icon.min.css') }}">

    <link rel="stylesheet" href="http://cdn.datatables.net/2.3.5/css/dataTables.dataTables.min.css">

    <link rel="stylesheet" type="text/css"
        href="https://cdn.jsdelivr.net/npm/@phosphor-icons/web@2.1.1/src/regular/style.css" />

    <link rel="stylesheet" type="text/css"
        href="https://cdn.jsdelivr.net/npm/@phosphor-icons/web@2.1.1/src/fill/style.css" />

    <link href="https://unpkg.com/filepond@^4/dist/filepond.css" rel="stylesheet" />

    <title>BMH | @yield('title')</title>

    <style>
        .big-i {
            font-size: 1.5rem !important;
        }
    </style>

    @yield('css')
</head>

<body>
    <div class="dashboard-main-wrapper">
        <div class="dashboard-header">
            <nav class="navbar navbar-expand-lg bg-white fixed-top">
                <a class="navbar-brand" href="{{ route('dashboard') }}">Book-My-Hotel</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse"
                    data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse " id="navbarSupportedContent">
                    <ul class="navbar-nav ml-auto navbar-right-top">
                        <li class="nav-item dropdown nav-user">
                            <a class="nav-link nav-user-img" href="#" id="navbarDropdownMenuLink2"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img src="{{ Avatar::create(Auth::user()->name)->toBase64() }}" alt="profile"
                                    class="user-avatar-md rounded-circle">
                            </a>
                            <div class="dropdown-menu dropdown-menu-right nav-user-dropdown"
                                aria-labelledby="navbarDropdownMenuLink2">
                                <div class="nav-user-info">
                                    <h5 class="mb-0 text-white nav-user-name">{{ Auth::user()->name }}</h5>
                                </div>

                                <a href="{{ route('logout') }}" class="dropdown-item d-flex align-items-center"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="ph ph-sign-out mr-2" style="font-size: 1.1rem"></i>
                                    <span class="ms-2">Logout</span>
                                </a>
                                <form action="{{ route('logout') }}" id="logout-form" method="POST"
                                    style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
        <div class="nav-left-sidebar sidebar-dark">
            <div class="menu-list">
                <nav class="navbar navbar-expand-lg navbar-light">
                    <a class="d-xl-none d-lg-none" href="#">Dashboard</a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav flex-column">
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('home') }}">
                                    <i class="ph ph-house-line big-i"></i>
                                    Home
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"
                                    href="{{ route('dashboard') }}">
                                    <i class="ph ph-speedometer big-i"></i>
                                    Dashboard
                                </a>
                            </li>
                            @role('customer')
                                <li class="nav-item">
                                    <a class="nav-link
                                    {{ request()->routeIs('customer.bookings.index') ? 'active' : '' }}"
                                        href="{{ route('customer.bookings.index') }}">
                                        <i class="ph ph-calendar-check big-i"></i>
                                        My Bookings
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link
                                    {{ request()->routeIs('customer.reviews.index') ? 'active' : '' }}"
                                        href="{{ route('customer.reviews.index') }}">
                                        <i class="ph ph-star big-i"></i>
                                        My Reviews
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link
                                    {{ request()->routeIs('customer.discounts.redeemed') ? 'active' : '' }}"
                                        href="{{ route('customer.discounts.redeemed') }}">
                                        <i class="ph ph-seal-percent big-i"></i>
                                        My Discounts
                                    </a>
                                </li>
                            @endrole
                            @role('admin')
                                <li class="nav-item">
                                    <a class="nav-link
                                    {{ Route::currentRouteName() == 'users.index' ? 'active' : '' }}"
                                        href="{{ route('users.index') }}">
                                        <i class="ph ph-users big-i"></i>
                                        Users
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link
                                    {{ Route::currentRouteName() == 'hotels.index' ? 'active' : '' }}"
                                        href="{{ route('hotels.index') }}">
                                        <i class="ph ph-building big-i"></i>
                                        Hotels
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link
                                    {{ request()->routeIs('rooms.index') ? 'active' : '' }}"
                                        href="{{ route('rooms.index') }}">
                                        <i class="ph ph-bed big-i"></i>
                                        Rooms
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link
                                    {{ request()->routeIs('reviews.index') ? 'active' : '' }}"
                                        href="{{ route('reviews.index') }}">
                                        <i class="ph ph-star big-i"></i>
                                        Reviews
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link
                                    {{ request()->routeIs('bookings.index') ? 'active' : '' }}"
                                        href="{{ route('bookings.index') }}">
                                        <i class="ph ph-calendar-check big-i"></i>
                                        Bookings
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link
                                    {{ request()->routeIs('discounts.index') ? 'active' : '' }}"
                                        href="{{ route('discounts.index') }}">
                                        <i class="ph ph-seal-percent big-i"></i>
                                        Discounts
                                    </a>
                                </li>
                            @endrole
                            @role('hotel_manager')
                                <li class="nav-item">
                                    <a class="nav-link {{ Route::currentRouteName() == 'manager.hotels.index' ? 'active' : '' }}"
                                        href="{{ route('manager.hotels.index') }}">
                                        <i class="ph ph-building big-i"></i>My Hotel</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ Route::currentRouteName() == 'manager.rooms.index' ? 'active' : '' }}"
                                        href="{{ route('manager.rooms.index') }}">
                                        <i class="ph ph-bed big-i"></i>My Rooms</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('manager.reviews.index') ? 'active' : '' }}"
                                        href="{{ route('manager.reviews.index') }}"><i class="ph ph-star big-i"></i>
                                        My Reviews
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('manager.bookings.index') ? 'active' : '' }}"
                                        href="{{ route('manager.bookings.index') }}"><i
                                            class="ph ph-calendar-check big-i"></i>
                                        My Bookings
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('promotions.index') ? 'active' : '' }}"
                                        href="{{ route('promotions.index') }}"><i class="ph ph-seal-percent big-i"></i>
                                        My Promotions
                                    </a>
                                </li>
                            @endrole
                        </ul>
                    </div>
                </nav>
            </div>
        </div>
        <div class="dashboard-wrapper">
            <div class="dashboard-ecommerce">
                <div class="container-fluid dashboard-content">
                    <div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="page-header">
                                <h2 class="pageheader-title">@yield('page-header')</h2>
                            </div>
                        </div>
                    </div>
                    @yield('content')
                </div>
            </div>

            <div class="footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 text-center">
                            Copyright &copy;
                            <script>
                                document.write(new Date().getFullYear())
                            </script> Book My Hotel. All rights reserved.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('dashboard/vendor/jquery/jquery-3.3.1.min.js') }}"></script>
    <script src="{{ asset('dashboard/vendor/bootstrap/js/bootstrap.bundle.js') }}"></script>
    <script src="{{ asset('dashboard/vendor/slimscroll/jquery.slimscroll.js') }}"></script>
    <script src="{{ asset('dashboard/libs/js/main-js.js') }}"></script>
    <script src="{{ asset('dashboard/vendor/charts/chartist-bundle/chartist.min.js') }}"></script>
    <script src="{{ asset('dashboard/vendor/charts/sparkline/jquery.sparkline.js') }}"></script>
    <script src="{{ asset('dashboard/vendor/charts/morris-bundle/raphael.min.js') }}"></script>
    <script src="{{ asset('dashboard/vendor/charts/morris-bundle/morris.js') }}"></script>
    <script src="{{ asset('dashboard/vendor/charts/c3charts/c3.min.js') }}"></script>
    <script src="{{ asset('dashboard/vendor/charts/c3charts/d3-5.4.0.min.js') }}"></script>
    <script src="{{ asset('dashboard/vendor/charts/c3charts/C3chartjs.js') }}"></script>
    <script src="{{ asset('dashboard/libs/js/dashboard-ecommerce.js') }}"></script>

    <script src="https://cdn.datatables.net/2.3.5/js/dataTables.min.js"></script>

    <script src="https://unpkg.com/filepond@^4/dist/filepond.js"></script>

    <script src="https://unpkg.com/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.js"></script>

    @yield('js')
</body>

</html>
