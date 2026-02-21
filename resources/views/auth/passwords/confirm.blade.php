@extends('layouts.auth')

@section('title', 'Confirm Password')

@section('content')
    <section>
        <div class="page-header min-vh-75">
            <div class="container">
                <div class="row">
                    <div class="col-xl-4 col-lg-5 col-md-6 d-flex flex-column mx-auto">
                        <div class="card card-plain mt-8">
                            <div class="card-header pb-0 text-left bg-transparent">
                                <h3 class="font-weight-bolder text-info text-gradient">Confirm Password</h3>
                                <p class="mb-0">Please confirm your password before continuing.</p>
                            </div>
                            <div class="card-body">
                                <form role="form" method="POST" action="{{ route('password.confirm') }}">
                                    @csrf

                                    {{-- Password --}}
                                    <label for="password">Password</label>
                                    <div class="mb-3">
                                        <input id="password" type="password"
                                            class="form-control @error('password') is-invalid @enderror"
                                            placeholder="Password" name="password" aria-label="Password" required
                                            autocomplete="current-password">
                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="align-items-center justify-content-between">
                                        @if (Route::has('password.request'))
                                            <a class="btn btn-link p-0 mb-1 text-info text-gradient font-weight-bold"
                                                href="{{ route('password.request') }}">
                                                Forgot Your Password?
                                            </a>
                                        @endif
                                    </div>

                                    <div class="text-center">
                                        <button type="submit" class="btn bg-gradient-info w-100 mt-4 mb-0">Confirm
                                            Password</button>
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
