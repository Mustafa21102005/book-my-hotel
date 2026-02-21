@extends('layouts.dashboard')

@section('title', 'Users')

@section('page-header', 'Users')

@section('content')
    <x-success-alert />

    <x-error-alert />

    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Users Table</h5>
                    <x-create-button route="users.create" label="Hotel Manager" />
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="users" class="table table-striped table-bordered first">
                            <thead>
                                <tr>
                                    <th class="text-center">ID</th>
                                    <th class="text-center">Name</th>
                                    <th class="text-center">Email</th>
                                    <th class="text-center">Email Verified</th>
                                    <th class="text-center">Role</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                    <tr>
                                        <td class="text-center">{{ $user->id }}</td>
                                        <td class="text-center">
                                            {{ $user->name }}
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('users.show', $user->id) }}">{{ $user->email }}</a>
                                        </td>
                                        <td class="text-center">
                                            @if ($user->email_verified_at)
                                                <i class="ph ph-check-fat text-success big-i"></i>
                                            @else
                                                <i class="ph ph-x text-danger big-i"></i>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @php
                                                $role = $user->roles->first()->name;
                                                if ($role === 'hotel_manager') {
                                                    $role = 'Hotel Manager';
                                                }
                                            @endphp
                                            {{ ucfirst($role) }}
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('users.edit', $user->id) }}"
                                                class="btn btn-outline-warning btn-sm mr-1">Edit</a>
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

        let table = new DataTable('#users', {
            responsive: true,
            language: {
                emptyTable: "No users found."
            }
        });
    </script>
@endsection
