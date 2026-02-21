@extends('layouts.dashboard')

@section('title', 'My Discounts')

@section('page-header', 'My Discounts')

@section('content')
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Discounts Table</h5>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table id="discounts" class="table table-striped table-bordered first">
                            <thead>
                                <tr>
                                    <th class="text-center">Code</th>
                                    <th class="text-center">Usage</th>
                                    <th class="text-center">Discount Percent</th>
                                    <th class="text-center">Expiry Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($redeemed as $rdm)
                                    <tr>
                                        <td class="text-center">{{ $rdm->discount->code }}</td>
                                        <td class="text-center">
                                            @if ($rdm->is_used)
                                                Used on {{ \Carbon\Carbon::parse($rdm->used_at)->format('d/m/Y') }}
                                            @else
                                                Not Used
                                            @endif
                                        </td>
                                        <td class="text-center">{{ $rdm->discount->discount_percent }}%</td>
                                        <td class="text-center">
                                            {{ $rdm->discount->expires_at ? \Carbon\Carbon::parse($rdm->discount->expires_at)->format('d/m/Y') : 'Does Not Expire' }}
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
