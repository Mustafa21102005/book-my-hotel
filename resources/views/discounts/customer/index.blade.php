@extends('layouts.app')

@section('title', 'Discount Codes')

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-10">

            {{-- User Points Summary --}}
            <div class="card my-4 shadow-sm">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Your Points</h5>
                    @auth
                        <h3 class="text-primary mb-0">
                            {{ $points->points ?? 0 }} <small class="text-muted">pts</small>
                        </h3>
                    @else
                        <h4 class="text-muted mb-0">
                            Please login to view your points
                            <img src="https://fonts.gstatic.com/s/e/notoemoji/latest/1f600/512.gif" width="36">
                        </h4>
                    @endauth
                </div>
            </div>

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                    {{ session('success') }}

                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>

                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            {{-- Discount Codes List --}}
            <div class="card shadow-sm mb-5">
                <h5 class="card-header">Discount Codes</h5>

                <div class="card-body">
                    @if ($discounts->isEmpty())
                        <p class="text-center text-muted">No discount codes available right now.</p>
                    @else
                        <div class="row">
                            @foreach ($discounts as $discount)
                                <div class="col-md-4 mb-4">
                                    <div class="card h-100 shadow-sm position-relative">

                                        {{-- Badge if redeemed --}}
                                        @if (in_array($discount->id, $redeemedDiscountIds))
                                            <span class="badge bg-success position-absolute top-0 end-0 m-2"
                                                style="font-size: 0.9rem;">
                                                Redeemed ✔
                                            </span>
                                        @endif

                                        <div class="card-body d-flex flex-column">
                                            <h5 class="card-title">{{ $discount->code }}</h5>
                                            <p class="text-muted mb-2">Value: {{ $discount->discount_percent }}%</p>

                                            {{-- Points required --}}
                                            <p class="mb-3">
                                                Cost:
                                                <strong
                                                    class="@auth{{ ($points->points ?? 0) >= $discount->points_required ? 'text-success' : 'text-danger' }} @else text-muted @endauth">
                                                    {{ $discount->points_required }} pts
                                                </strong>
                                            </p>

                                            @auth
                                                <form action="{{ route('discounts.redeem', $discount) }}" method="POST"
                                                    class="mt-auto">
                                                    @csrf

                                                    {{-- If redeemed --}}
                                                    @if (in_array($discount->id, $redeemedDiscountIds))
                                                        <button class="btn btn-outline-success w-100" disabled>
                                                            Already Redeemed
                                                        </button>
                                                    @elseif (($points->points ?? 0) >= $discount->points_required)
                                                        {{-- If enough points --}}
                                                        <button class="btn btn-primary w-100">Redeem</button>
                                                    @else
                                                        {{-- Not enough points --}}
                                                        <button class="btn btn-secondary w-100" disabled>
                                                            Not enough points
                                                        </button>
                                                    @endif
                                                </form>
                                            @else
                                                <a href="{{ route('login') }}" class="btn-outline">Login to Redeem</a>
                                            @endauth
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
