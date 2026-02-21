@extends('layouts.auth')

@section('title', 'Forgot Password')

@section('css')
    <style>
        .arrow-back {
            display: inline-block;
            transition: 0.3s all ease;
        }

        .arrow-back:hover {
            transform: translateX(-3px);
        }
    </style>
@endsection

@section('content')
    <section>
        <div class="page-header min-vh-75">
            <div class="container">
                <div class="row">
                    <div class="col-xl-4 col-lg-5 col-md-6 d-flex flex-column mx-auto">
                        <div class="card card-plain mt-8">
                            <div class="card-header pb-0 text-left bg-transparent">
                                <h3 class="font-weight-bolder text-info text-gradient">
                                    Forgot Your Password?
                                </h3>
                                <p class="mb-0">
                                    Don't worry just enter your email and we will send you a link!
                                </p>
                            </div>
                            <div class="card-body">

                                @if (session('status'))
                                    <div class="alert alert-success" role="alert">
                                        {{ session('status') }}
                                    </div>
                                @endif

                                <form role="form" method="POST" action="{{ route('password.email') }}">
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

                                    <div class="text-center">
                                        <button type="submit" class="btn bg-gradient-info w-100 mt-4 mb-0">
                                            Send Password Reset Link
                                        </button>
                                    </div>
                                </form>
                            </div>
                            <div class="card-footer text-center pt-0 px-lg-2 px-1">
                                <p class="mb-4 text-sm mx-auto d-flex justify-content-center align-items-center gap-1">
                                    <a href="{{ route('login') }}"
                                        class="arrow-back text-info text-gradient font-weight-bold d-inline-flex align-items-center"
                                        style="font-size: 15px;">
                                        <i class="ph-bold ph-arrow-left me-1" style="font-size: 18px"></i>
                                        Back to Log in
                                    </a>
                                </p>
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
