@extends('layouts.dashboard')

@section('title', 'Rooms')

@section('page-header', 'Rooms')

@section('content')
    <x-success-alert />

    <x-error-alert />

    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Rooms Table</h5>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table id="rooms" class="table table-striped table-bordered first">
                            <thead>
                                <tr>
                                    <th class="text-center">ID</th>
                                    <th class="text-center">Hotel</th>
                                    <th class="text-center">Room</th>
                                    <th class="text-center">Type</th>
                                    <th class="text-center">Price per Night</th>
                                    <th class="text-center">Capacity</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($rooms as $room)
                                    <tr>
                                        <td class="text-center">{{ $room->id }}</td>
                                        <td class="text-center">
                                            <a href="{{ route('hotels.show', $room->hotel->id) }}">
                                                {{ $room->hotel->name }}
                                            </a>
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('rooms.show', $room->id) }}">{{ $room->name }}</a>
                                        </td>
                                        <td class="text-center">
                                            {{ ucfirst($room->type) }}
                                        </td>
                                        <td class="text-center">
                                            AED {{ $room->price }}
                                        </td>
                                        <td class="text-center">
                                            {{ $room->capacity }}
                                        </td>
                                        <td class="text-center">
                                            <x-edit-button route="rooms.edit" :id="$room->id" />

                                            <x-delete-button id="deleteRoom{{ $room->id }}"
                                                action-url="{{ route('rooms.destroy', $room->id) }}" title="Delete Room?"
                                                message="Are you sure you want to delete this room?" />
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

        let table = new DataTable('#rooms', {
            responsive: true,
            language: {
                emptyTable: "No rooms found."
            }
        });
    </script>
@endsection
