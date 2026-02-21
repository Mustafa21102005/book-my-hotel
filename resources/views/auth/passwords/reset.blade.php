@extends('layouts.auth')

@section('title', 'Password Reset')

@section('content')
    <section>
        <div class="page-header min-vh-75">
            <div class="container">
                <div class="row">
                    <div class="col-xl-4 col-lg-5 col-md-6 d-flex flex-column mx-auto">
                        <div class="card card-plain mt-8">
                            <div class="card-header pb-0 text-left bg-transparent">
                                <h3 class="font-weight-bolder text-info text-gradient">Reset Password</h3>
                                <p class="mb-0">Set your new password here!</p>
                            </div>
                            <div class="card-body">
                                <form role="form" method="POST" action="{{ route('password.update') }}">
                                    @csrf

                                    {{-- Token --}}
                                    <input type="hidden" name="token" value="{{ $token }}">

                                    {{-- Email --}}
                                    <label for="email">Email</label>
                                    <div class="mb-3">
                                        <input id="email" type="email"
                                            class="form-control @error('email') is-invalid @enderror" placeholder="Email"
                                            name="email" aria-label="Email" aria-describedby="email-addon" required
                                            autofocus autocomplete="email" value="{{ $email ?? old('email') }}">
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    {{-- Confirm Password --}}
                                    <label for="password-confirm">Confirm Password</label>
                                    <div class="mb-3">
                                        <input id="password-confirm" type="password" class="form-control"
                                            placeholder="Confirm Password" name="password_confirmation"
                                            aria-label="Confirm Password" required autocomplete="new-password">
                                    </div>

                                    <div class="text-center">
                                        <button type="submit" class="btn bg-gradient-info w-100 mt-4 mb-0">
                                            Reset Password
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="oblique position-absolute top-0 h-100 d-md-block d-none me-n8">
                            <div class="oblique-image bg-cover position-absolute fixed-top ms-auto h-100 z-index-0 ms-n6"
                                style="background-image:url('../auth/img/curved-images/curved6.jpg')"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
