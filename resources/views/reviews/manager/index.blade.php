@extends('layouts.dashboard')

@section('title', 'My Reviews')

@section('page-header', 'My Reviews')

@section('content')
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <h5 class="card-header">My Reviews Table</h5>

                <div class="card-body">
                    <div class="table-responsive">
                        <table id="reviews" class="table table-striped table-bordered first">
                            <thead>
                                <tr>
                                    <th class="text-center">Customer</th>
                                    <th class="text-center">Rating</th>
                                    <th class="text-center">Title</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($reviews as $review)
                                    <tr>
                                        <td class="text-center">
                                            {{ $review->user->name }}
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
                                            {{ Str::limit($review->title, 30) }}</td>
                                        <td class="text-center">
                                            <a href="{{ route('reviews.show', $review->id) }}"
                                                class="btn btn-outline-info btn-sm">
                                                View
                                            </a>
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
