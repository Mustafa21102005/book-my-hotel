<!--
=========================================================
* Soft UI Dashboard 3 - v1.1.0
=========================================================

* Product Page: https://www.creative-tim.com/product/soft-ui-dashboard
* Copyright 2024 Creative Tim (https://www.creative-tim.com)
* Licensed under MIT (https://www.creative-tim.com/license)
* Coded by Creative Tim

=========================================================

* The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
-->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>
        BMH | @yield('title')
    </title>

    <link rel="icon" type="image/png" href="{{ asset('auth/favicon/favicon-96x96.png') }}" sizes="96x96" />
    <link rel="icon" type="image/svg+xml" href="{{ asset('auth/favicon/favicon.svg') }}" />
    <link rel="shortcut icon" href="{{ asset('auth/favicon/favicon.ico') }}" />
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('auth/favicon/apple-touch-icon.png') }}" />
    <link rel="manifest" href="{{ asset('auth/favicon/site.webmanifest') }}" />

    {{-- Fonts and icons --}}
    <link href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700,800" rel="stylesheet" />

    {{-- Phospor Icons --}}
    <link rel="stylesheet" type="text/css"
        href="https://cdn.jsdelivr.net/npm/@phosphor-icons/web@2.1.2/src/bold/style.css" />

    {{-- CSS Files --}}
    <link id="pagestyle" href="{{ asset('auth/css/soft-ui-dashboard.css?v=1.1.0') }}" rel="stylesheet" />

    @yield('css')
</head>

<body>
    <div class="container position-sticky z-index-sticky top-0">
        <div class="row">
            <div class="col-12">
                <nav
                    class="navbar navbar-expand-lg blur blur-rounded top-0 z-index-3 shadow position-absolute my-3 py-2 start-0 end-0 mx-4">
                    <div class="container-fluid pe-0">
                        <a class="navbar-brand font-weight-bolder ms-lg-0 ms-3 " href="{{ route('home') }}">
                            Book My Hotel
                        </a>
                    </div>
                </nav>
            </div>
        </div>
    </div>

    <main class="main-content  mt-0">
        @yield('content')
    </main>

    <footer class="footer py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mb-4 mx-auto text-center">
                    <a href="{{ route('home') }}" class="text-secondary me-xl-5 me-3 mb-sm-0 mb-2">
                        Home
                    </a>
                    <a href="{{ route('customer.hotels.index') }}" class="text-secondary me-xl-5 me-3 mb-sm-0 mb-2">
                        Hotels
                    </a>
                    <a href="{{ route('customer.rooms.index') }}" class="text-secondary me-xl-5 me-3 mb-sm-0 mb-2">
                        Rooms
                    </a>
                    <a href="{{ route('cancellation') }}" class="text-secondary me-xl-5 me-3 mb-sm-0 mb-2">
                        Cancellation Policy
                    </a>
                </div>
            </div>
            <div class="row">
                <div class="col-8 mx-auto text-center mt-1">
                    <p class="mb-0 text-secondary">
                        Copyright &copy;
                        <script>
                            document.write(new Date().getFullYear())
                        </script> Book-My-Hotel
                    </p>
                </div>
            </div>
        </div>
    </footer>

    {{-- Core JS Files --}}
    <script src="{{ asset('auth/js/core/popper.min.js') }}"></script>
    <script src="{{ asset('auth/js/core/bootstrap.min.js') }}"></script>
    <script src="{{ asset('auth/js/plugins/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('auth/js/plugins/smooth-scrollbar.min.js') }}"></script>
    <script src="{{ asset('auth/js/soft-ui-dashboard.min.js?v=1.1.0') }}"></script>

    @yield('js')
</body>

</html>
