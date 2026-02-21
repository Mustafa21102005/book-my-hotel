@extends('layouts.app')

@section('title', 'Payment Status')

@section('content')
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-6">

                <div class="card text-center shadow-lg p-4" style="border-radius: 15px;">
                    <div class="card-body">
                        <div class="mb-3">
                            <span class="display-1 text-success">✅</span>
                        </div>
                        <h3 class="card-title mb-3 text-success">Payment Successful!</h3>
                        <p class="card-text">
                            A confirmation email has been sent to
                            <strong>{{ $customerEmail ?? 'your email' }}</strong>.
                        </p>

                        @if ($earnedEcoPoints)
                            <div class="alert alert-success mt-3">
                                🌿 You earned <strong>20 Points</strong> for booking an eco-friendly hotel!
                            </div>
                        @endif

                        <a href="{{ route('home') }}" class="btn btn-success mt-3">Return Home</a>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
