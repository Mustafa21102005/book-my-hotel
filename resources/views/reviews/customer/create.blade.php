@extends('layouts.dashboard')

@section('title', 'Add Review')

@section('page-header', 'Add Review')

@section('content')
    <x-error-alert />

    <div class="row">
        <div class="col-12">
            <div class="card">
                <h5 class="card-header">Add Review for {{ $booking->room->hotel->name }}</h5>

                <div class="card-body">
                    <form action="{{ route('reviews.store') }}" method="POST">
                        @csrf

                        <input type="hidden" name="booking_id" value="{{ $booking->id }}">

                        <div class="mb-3">
                            <label class="form-label">Rating</label>
                            <div id="starContainer" style="font-size: 2rem; cursor: pointer;">
                                @for ($i = 1; $i <= 5; $i++)
                                    <span class="star" data-value="{{ $i }}">&#9733;</span>
                                @endfor
                            </div>

                            <input type="hidden" name="rating" id="rating" value="5">

                            @error('rating')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" id="title"
                                name="title" value="{{ old('title') }}" required autofocus>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="comment" class="form-label">Comment (optional)</label>
                            <textarea class="form-control @error('comment') is-invalid @enderror" id="comment" name="comment" rows="4">{{ old('comment') }}</textarea>
                            @error('comment')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="text-center mt-4">
                            <button type="submit" class="btn btn-primary">Add</button>
                            <a href="{{ route('rooms.index') }}" class="btn btn-secondary">Cancel</a>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const stars = document.querySelectorAll('.star');
            const ratingInput = document.getElementById('rating');

            let selectedRating = 5; // default

            function highlightStars(rating) {
                stars.forEach(star => {
                    star.style.color = star.dataset.value <= rating ? '#fbc02d' : '#ccc';
                });
            }

            // Initial highlight
            highlightStars(selectedRating);

            stars.forEach(star => {
                star.addEventListener('mouseenter', function() {
                    highlightStars(this.dataset.value);
                });

                star.addEventListener('mouseleave', function() {
                    highlightStars(selectedRating);
                });

                star.addEventListener('click', function() {
                    selectedRating = this.dataset.value;
                    ratingInput.value = selectedRating;
                    highlightStars(selectedRating);
                });
            });
        });
    </script>
@endsection
