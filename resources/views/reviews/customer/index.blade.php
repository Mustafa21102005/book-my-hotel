@extends('layouts.dashboard')

@section('title', 'My Reviews')

@section('page-header', 'My Reviews')

@section('content')
    <x-success-alert />

    <x-error-alert />

    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <h5 class="card-header">My Reviews Table</h5>

                <div class="card-body">
                    <div class="table-responsive">
                        <table id="reviews" class="table table-striped table-bordered first">
                            <thead>
                                <tr>
                                    <th class="text-center">Hotel</th>
                                    <th class="text-center">Rating</th>
                                    <th class="text-center">Title</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($reviews as $review)
                                    <tr>
                                        <td class="text-center">
                                            {{ $review->hotel->name }}
                                        </td>
                                        <td class="text-center">
                                            @for ($i = 1; $i <= 5; $i++)
                                                @if ($i <= $review->rating)
                                                    <i class="ph-fill ph-star text-warning"></i>
                                                @else
                                                    <i class="ph ph-star text-warning"></i>
                                                @endif
                                            @endfor
                                        </td>
                                        <td class="text-center">
                                            {{ Str::limit($review->title, 30) }}
                                        </td>
                                        </td>
                                        <td class="text-center">
                                            <x-view-button :url="route('reviews.show', $review->id)" />
                                            <x-delete-button id="deleteReview{{ $review->id }}"
                                                action-url="{{ route('reviews.destroy', $review->id) }}"
                                                title="Delete Review?"
                                                message="Are you sure you want to delete this review?" />
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        $.fn.dataTable.ext.errMode = 'none'; // disables console warnings

        let table = new DataTable('#reviews', {
            responsive: true,
            language: {
                emptyTable: "No reviews found."
            }
        });
    </script>
@endsection
