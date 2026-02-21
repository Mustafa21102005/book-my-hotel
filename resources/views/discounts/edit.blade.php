@extends('layouts.dashboard')

@section('title', 'Edit Discount')

@section('page-header', 'Edit Discount')

@section('content')
    <x-error-alert />

    <div class="row">
        <div class="col-12">
            <div class="card">
                <h5 class="card-header">Edit Discount</h5>
                <div class="card-body">
                    <form action="{{ route('discounts.update', $discount->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="points_required" class="form-label">Points Required</label>
                            <input type="number" min="1"
                                class="form-control @error('points_required') is-invalid @enderror" id="points_required"
                                name="points_required" value="{{ old('points_required', $discount->points_required) }}"
                                required>
                            @error('points_required')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="discount_percent" class="form-label">Discount Percent</label>
                            <input type="number" min="1"
                                class="form-control @error('discount_percent') is-invalid @enderror" id="discount_percent"
                                name="discount_percent" value="{{ old('discount_percent', $discount->discount_percent) }}"
                                required>
                            @error('discount_percent')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="expires_at" class="form-label">Expires At</label>
                            <input type="date" class="form-control @error('expires_at') is-invalid @enderror"
                                id="expires_at" name="expires_at"
                                value="{{ old('expires_at', optional($discount->expires_at)->format('Y-m-d')) }}">
                            @error('expires_at')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">Update</button>
                            <a href="{{ route('discounts.index') }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
