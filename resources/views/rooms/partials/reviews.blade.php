@foreach ($reviews as $review)
    <div class="thmv-user-review mb-5">
        <div class="thmv-review-box">
            <div class="thmv-user-title">
                <h6>{{ $review->title }}</h6>
                <p class="mb-0"><i class="fas fa-star"></i>
                    <strong>{{ $review->rating }}</strong>
                </p>
            </div>
            <div class="thmv-user-text">
                <p class="thmv-p-light">{{ $review->comment }}</p>
            </div>
            <div class="thmv-user-data">
                <div class="thmv-user-img">
                    <img src="{{ Avatar::create($review->user->name)->toBase64() }}" alt="profile">
                </div>
                <div class="thmv-user-name">
                    <h6>{{ $review->user->name }}</h6>
                    <p class="thmv-p-light m-0">
                        {{ $review->created_at->diffForHumans() }}
                    </p>
                </div>
            </div>
        </div>
    </div>
@endforeach

<x-pagination :paginator="$reviews" />
