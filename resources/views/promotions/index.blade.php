@extends('layouts.dashboard')

@section('title', 'My Promotions')

@section('page-header', 'My Promotions')

@section('content')
    <x-success-alert />

    <x-error-alert />

    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">My Promotions Table</h5>
                    <x-create-button route="promotions.create" label="Promotion" />
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="promotions" class="table table-striped table-bordered first">
                            <thead>
                                <tr>
                                    <th class="text-center">Title</th>
                                    <th class="text-center">Description</th>
                                    <th class="text-center">Discount Percent</th>
                                    <th class="text-center">Start Date</th>
                                    <th class="text-center">End Date</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($promotions as $promotion)
                                    <tr>
                                        <td class="text-center">
                                            <a href="{{ route('promotions.show', $promotion->id) }}">
                                                {{ Str::limit($promotion->title, 30) }}
                                            </a>
                                        </td>
                                        <td class="text-center">
                                            {{ Str::limit($promotion->description ?? 'No description', 30) }}
                                        </td>
                                        <td class="text-center">{{ $promotion->discount_percent }}%</td>
                                        <td class="text-center">{{ $promotion->start_date }}</td>
                                        <td class="text-center">{{ $promotion->end_date }}</td>
                                        <td class="text-center">
                                            <x-edit-button route="promotions.edit" :id="$promotion->id" />
                                            <x-delete-button id="deletePromotion{{ $promotion->id }}"
                                                action-url="{{ route('promotions.destroy', $promotion->id) }}"
                                                title="Delete Promotion?"
                                                message="Are you sure you want to delete this promotion?" />
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

        let table = new DataTable('#promotions', {
            responsive: true,
            language: {
                emptyTable: "No promotions found."
            }
        });
    </script>
@endsection
