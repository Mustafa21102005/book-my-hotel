@extends('layouts.dashboard')

@section('title', 'Hotels')

@section('page-header', 'Hotels')

@section('content')
    <x-success-alert />

    <x-error-alert />

    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Hotels Table</h5>
                    @can('create', App\Models\Hotel::class)
                        <x-create-button route="hotels.create" label="Hotel" />
                    @endcan
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table id="hotels" class="table table-striped table-bordered first">
                            <thead>
                                <tr>
                                    <th class="text-center">Name</th>
                                    <th class="text-center">Description</th>
                                    <th class="text-center">Region</th>
                                    <th class="text-center">Country</th>
                                    <th class="text-center">City</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($hotels as $hotel)
                                    <tr>
                                        <td class="text-center">
                                            <a href="{{ route('hotels.show', $hotel->id) }}">
                                                {{ $hotel->name }}
                                            </a>
                                        </td>
                                        <td class="text-center">
                                            {{ Str::limit($hotel->description ?? 'No description', 30) }}
                                        </td>
                                        <td class="text-center">
                                            {{ $hotel->region }}
                                        </td>
                                        </td>
                                        <td class="text-center">
                                            {{ $hotel->country }}
                                        </td>
                                        <td class="text-center">
                                            {{ $hotel->city }}
                                        </td>
                                        <td class="text-center">
                                            <x-edit-button route="hotels.edit" :id="$hotel->id" />

                                            <x-delete-button id="deleteHotel{{ $hotel->id }}"
                                                action-url="{{ route('hotels.destroy', $hotel->id) }}" title="Delete Hotel?"
                                                message="Are you sure you want to delete your hotel?" />
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
        $.fn.dataTable.ext.errMode = 'none';

        let table = new DataTable('#hotels', {
            responsive: true,
            language: {
                emptyTable: "No hotel found."
            }
        });
    </script>
@endsection
