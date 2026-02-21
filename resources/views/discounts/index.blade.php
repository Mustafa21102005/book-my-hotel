@extends('layouts.dashboard')

@section('title', 'Discounts')

@section('page-header', 'Discounts')

@section('content')
    <x-success-alert />

    <x-error-alert />

    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Discounts Table</h5>
                    <x-create-button route="discounts.create" label="Discount" />
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table id="discounts" class="table table-striped table-bordered first">
                            <thead>
                                <tr>
                                    <th class="text-center">ID</th>
                                    <th class="text-center">Code</th>
                                    <th class="text-center">Points Required</th>
                                    <th class="text-center">Discount</th>
                                    <th class="text-center">Expiry Date</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($discounts as $discount)
                                    <tr>
                                        <td class="text-center">{{ $discount->id }}</td>
                                        <td class="text-center">{{ $discount->code }}</td>
                                        <td class="text-center">{{ $discount->points_required }}</td>
                                        <td class="text-center">{{ $discount->discount_percent }}%</td>
                                        <td class="text-center">
                                            {{ $discount->expires_at ? \Carbon\Carbon::parse($discount->expires_at)->format('d/m/Y') : 'Does Not Expire' }}
                                        </td>
                                        <td class="text-center">
                                            <x-edit-button route="discounts.edit" :id="$discount->id" />

                                            <x-delete-button id="deleteDiscount{{ $discount->id }}"
                                                action-url="{{ route('discounts.destroy', $discount->id) }}"
                                                title="Delete Discount?"
                                                message="Are you sure you want to delete this discount?" />
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

        let table = new DataTable('#discounts', {
            responsive: true,
            language: {
                emptyTable: "No discounts found."
            }
        });
    </script>
@endsection
