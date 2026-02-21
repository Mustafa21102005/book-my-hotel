@extends('layouts.auth')

@section('title', 'Sign Up')

@section('content')
    <section>
        <div class="page-header align-items-start min-vh-50 pt-5 pb-11 m-3 border-radius-lg"
            style="background-image: url('auth/img/curved-images/curved14.jpg');">
            <span class="mask bg-gradient-dark opacity-6"></span>
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-5 text-center mx-auto">
                        <h1 class="text-white mb-2 mt-5">Welcome!</h1>
                        <p class="text-lead text-white">Use this awesome form to create your new account!</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row mt-lg-n10 mt-md-n11 mt-n10">
                <div class="col-xl-4 col-lg-5 col-md-7 mx-auto">
                    <div class="card z-index-0">
                        <div class="card-header text-center">
                            <h5>Sign Up</h5>
                        </div>
                        <div class="card-body">
                            <form role="form text-left" method="POST" action="{{ route('register') }}">
                                @csrf

                                {{-- Name --}}
                                <div class="mb-3">
                                    <label for="name">Name</label>
                                    <input type="text" id="name"
                                        class="form-control @error('name') is-invalid @enderror" placeholder="Name"
                                        aria-label="Name" aria-describedby="email-addon" value="{{ old('name') }}"
                                        name="name" required autocomplete="name" autofocus>
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                {{-- Email --}}
                                <div class="mb-3">
                                    <label for="email">Email</label>
                                    <input id="email" type="email"
                                        class="form-control @error('email') is-invalid @enderror" placeholder="Email"
                                        aria-label="Email" aria-describedby="email-addon" name="email"
                                        value="{{ old('email') }}" autocomplete="email" required>
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                {{-- Password --}}
                                <div class="mb-3">
                                    <label for="password">Password</label>
                                    <input id="password" type="password"
                                        class="form-control @error('password') is-invalid @enderror" placeholder="Password"
                                        aria-label="Password" name="password" required aria-describedby="password-addon"
                                        autocomplete="new-password">
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                {{-- Confirm Password --}}
                                <div class="mb-3">
                                    <label for="password-confirm">Confirm Password</label>
                                    <input id="password-confirm" type="password"
                                        class="form-control @error('password') is-invalid @enderror"
                                        placeholder="Confirm Password" aria-label="Password" name="password_confirmation"
                                        required aria-describedby="password-addon" autocomplete="new-password">
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="text-center">
                                    <button type="submit" class="btn bg-gradient-dark w-100 my-4 mb-2">
                                        Sign up
                                    </button>
                                </div>

                                <p class="text-sm text-center mt-3 mb-0">Already have an account?
                                    <a href="{{ route('login') }}" class="text-dark font-weight-bolder">
                                        Log in
                                    </a>
                                </p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
