@extends('layouts.dashboard')

@section('title', 'Promotion')

@section('page-header', 'Promotion')

@section('content')
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Promotion Details</h5>
                    <x-back-button route="promotions.index" label="My Promotions" />
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 mt-3">
                            <h6 class="text-muted">ID</h6>
                            <p>{{ $promotion->id }}</p>
                        </div>
                        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 mt-3">
                            <h6 class="text-muted">Title</h6>
                            <p>{{ $promotion->title }}</p>
                        </div>
                        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 mt-3">
                            <h6 class="text-muted">Description</h6>
                            <p>{{ $promotion->description }}</p>
                        </div>
                        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 mt-3">
                            <h6 class="text-muted">Discount Percent</h6>
                            <p>{{ $promotion->discount_percent }}%</p>
                        </div>
                        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 mt-3">
                            <h6 class="text-muted">Start Date</h6>
                            <p>{{ $promotion->start_date }}</p>
                        </div>
                        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 mt-3">
                            <h6 class="text-muted">End Date</h6>
                            <p>{{ $promotion->end_date }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
