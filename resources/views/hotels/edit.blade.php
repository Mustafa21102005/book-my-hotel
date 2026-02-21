@extends('layouts.dashboard')

@section('title', 'Edit Hotel')

@section('page-header', 'Edit Hotel')

@section('content')
    <x-error-alert />

    <div class="row">
        <div class="col-12">
            <div class="card">
                <h5 class="card-header">Edit Hotel</h5>
                <div class="card-body">
                    <form action="{{ route('hotels.update', $hotel->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="name" class="form-label">Hotel Name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                name="name" value="{{ old('name', $hotel->name) }}" required autofocus>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                                rows="3">{{ old('description', $hotel->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="region" class="form-label">Region</label>
                            <select name="region" id="region" class="form-control @error('region') is-invalid @enderror"
                                required>
                                <option disabled>Select a region</option>
                                <option value="asia" {{ old('region', $hotel->region) == 'asia' ? 'selected' : '' }}>Asia
                                </option>
                                <option value="europe" {{ old('region', $hotel->region) == 'europe' ? 'selected' : '' }}>
                                    Europe</option>
                            </select>
                            @error('region')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="country" class="form-label">Country</label>
                            <input type="text" class="form-control @error('country') is-invalid @enderror" id="country"
                                name="country" value="{{ old('country', $hotel->country) }}" required>
                            @error('country')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="city" class="form-label">City</label>
                            <input type="text" class="form-control @error('city') is-invalid @enderror" id="city"
                                name="city" value="{{ old('city', $hotel->city) }}" required>
                            @error('city')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="street" class="form-label">Street</label>
                            <input type="text" class="form-control @error('street') is-invalid @enderror" id="street"
                                name="street" value="{{ old('street', $hotel->street) }}" required>
                            @error('street')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="files">Add Images</label>
                            <input type="file" name="file" id="files"
                                class="form-control @error('file') is-invalid @enderror" multiple>
                            @error('file')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <input type="hidden" name="uploaded_files" id="uploaded_files">

                        <div class="mb-3">
                            <label class="form-label">Hotel Images</label>
                            @if ($files->isNotEmpty())
                                <ul class="list-group">
                                    @foreach ($files as $file)
                                        @php
                                            $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
                                        @endphp
                                        <li class="list-group-item d-flex flex-column flex-md-row align-items-start gap-3">
                                            <div class="preview-wrapper" style="width:300px; max-width:35%;">
                                                <div class="file-preview border rounded p-2 text-center"
                                                    style="min-height:100px; background-color:#f9f9f9;">
                                                    @if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp', 'bmp', 'svg']))
                                                        <img src="{{ $file['url'] }}" class="img-fluid rounded"
                                                            style="max-height:240px; object-fit:contain;"
                                                            alt="{{ $file['name'] }}">
                                                    @else
                                                        <p class="text-muted mt-3">Preview not available for this file type.
                                                        </p>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="grow mt-3 mt-md-0">
                                                <h6 class="mb-2 ml-3">
                                                    <a href="{{ $file['url'] }}"
                                                        class="text-decoration-none text-primary fw-bold">
                                                        {{ $file['name'] }}
                                                    </a>
                                                </h6>
                                                <small class="text-muted ml-3">
                                                    Size: {{ number_format($file['size'] / 1024, 2) }} KB
                                                </small>
                                                <div class="ml-3 mt-2">
                                                    <button type="button" class="btn btn-sm btn-danger delete-file-btn"
                                                        data-id="{{ $file['id'] }}">
                                                        Delete
                                                    </button>
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <p class="text-muted">No images uploaded yet.</p>
                            @endif
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Hotel Features</label>
                            @php
                                $features = ['breakfast', 'wifi', 'pool', 'gym', 'pets_allowed', 'environment'];
                            @endphp

                            @foreach ($features as $feature)
                                <div class="form-check">
                                    <input class="form-check-input @error($feature) is-invalid @enderror" type="checkbox"
                                        name="{{ $feature }}" id="{{ $feature }}" value="1"
                                        {{ old($feature, $hotel->$feature) ? 'checked' : '' }}>
                                    <label class="form-check-label"
                                        for="{{ $feature }}">{{ ucfirst(str_replace('_', ' ', $feature)) }}</label>
                                    @error($feature)
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            @endforeach
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">Update</button>
                            @role('hotel_manager')
                                <a href="{{ route('manager.hotels.index') }}" class="btn btn-secondary">
                                    Cancel
                                </a>
                            @endrole
                            @role('admin')
                                <a href="{{ route('hotels.index') }}" class="btn btn-secondary">Cancel</a>
                            @endrole
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
            // ================= FilePond =================
            FilePond.registerPlugin(FilePondPluginFileValidateType);

            const inputElement = document.querySelector('#files');

            FilePond.create(inputElement, {
                allowMultiple: true,
                allowRevert: true,
                allowPreview: true,
                acceptedFileTypes: [
                    'image/*'
                ],
                labelIdle: 'Drag & Drop files or <span class="filepond--label-action">Browse</span>',
                server: {
                    process: {
                        url: '/uploads',
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        onload: (response) => {
                            const data = JSON.parse(response);
                            let uploaded = document.getElementById('uploaded_files').value;
                            let list = uploaded ? JSON.parse(uploaded) : [];
                            list.push(data);
                            document.getElementById('uploaded_files').value = JSON.stringify(list);
                            return data.folder;
                        },
                        onerror: (response) => console.error('Upload failed', response)
                    },
                    revert: (uniqueFileId, load, error) => {
                        let uploadedInput = document.getElementById('uploaded_files');
                        let uploadedList = uploadedInput.value ? JSON.parse(uploadedInput.value) : [];
                        uploadedList = uploadedList.filter(file => file.folder !== uniqueFileId);
                        uploadedInput.value = JSON.stringify(uploadedList);

                        fetch(`/uploads/revert/${uniqueFileId}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            }
                        }).then(() => load()).catch(() => error('Could not revert file'));
                    }
                }
            });

            // ================= Delete Media =================
            const deleteButtons = document.querySelectorAll('.delete-file-btn');

            deleteButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const mediaId = this.dataset.id;

                    if (!confirm('Are you sure you want to delete this file?')) return;

                    fetch(`/hotels/${mediaId}/delete`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json'
                            }
                        })
                        .then(res => res.json())
                        .then(data => {
                            if (data.success) {
                                this.closest('li').remove();
                            } else {
                                alert('Failed to delete the file.');
                            }
                        })
                        .catch(() => alert('Failed to delete the file.'));
                });
            });
        });
    </script>
@endsection
