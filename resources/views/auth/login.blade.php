@extends('layouts.auth')

@section('title', 'Log In')

@section('content')
    <section>
        <div class="page-header min-vh-75">
            <div class="container">
                <div class="row">
                    <div class="col-xl-4 col-lg-5 col-md-6 d-flex flex-column mx-auto">
                        <div class="card card-plain mt-8">
                            <div class="card-header pb-0 text-left bg-transparent">
                                <h3 class="font-weight-bolder text-info text-gradient">Welcome back</h3>
                                <p class="mb-0">Enter your email and password to log in</p>
                            </div>
                            <div class="card-body">
                                <form role="form" method="POST" action="{{ route('login') }}">
                                    @csrf

                                    {{-- Email --}}
                                    <label for="email">Email</label>
                                    <div class="mb-3">
                                        <input id="email" type="email"
                                            class="form-control @error('email') is-invalid @enderror" placeholder="Email"
                                            name="email" aria-label="Email" aria-describedby="email-addon" required
                                            autofocus autocomplete="email" value="{{ old('email') }}">
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    {{-- Password --}}
                                    <label for="password">Password</label>
                                    <div class="mb-3">
                                        <input id="password" type="password"
                                            class="form-control @error('password') is-invalid @enderror"
                                            placeholder="Password" aria-label="Password" aria-describedby="password-addon"
                                            name="password" required autocomplete="current-password">
                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="d-flex align-items-center justify-content-between">
                                        <div class="form-check form-switch mb-0">
                                            <input name="remember" class="form-check-input" type="checkbox" id="remember"
                                                {{ old('remember') ? 'checked' : '' }}>
                                            <label class="form-check-label" for="remember">Remember me</label>
                                        </div>

                                        @if (Route::has('password.request'))
                                            <a class="btn btn-link p-0 mb-1 text-info text-gradient font-weight-bold"
                                                href="{{ route('password.request') }}">
                                                Forgot Your Password?
                                            </a>
                                        @endif
                                    </div>

                                    <div class="text-center">
                                        <button type="submit" class="btn bg-gradient-info w-100 mt-4 mb-0">Log
                                            in</button>
                                    </div>
                                </form>
                            </div>
                            <div class="card-footer text-center pt-0 px-lg-2 px-1">
                                <p class="mb-4 text-sm mx-auto">
                                    Don't have an account?
                                    <a href="{{ route('register') }}" class="text-info text-gradient font-weight-bold">
                                        Sign up
                                    </a>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="oblique position-absolute top-0 h-100 d-md-block d-none me-n8">
                            <div class="oblique-image bg-cover position-absolute fixed-top ms-auto h-100 z-index-0 ms-n6"
                                style="background-image: url('{{ asset('auth/img/curved-images/curved6.jpg') }}')">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
