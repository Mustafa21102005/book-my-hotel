@extends('layouts.dashboard')

@section('title', 'Edit Room')

@section('page-header', 'Edit Room')

@section('content')
    <x-error-alert />

    <div class="row">
        <div class="col-12">
            <div class="card">
                <h5 class="card-header">Edit Room</h5>
                <div class="card-body">
                    <form action="{{ route('rooms.update', $room->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        {{-- Room Name --}}
                        <div class="mb-3">
                            <label for="name" class="form-label">Room Name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                name="name" value="{{ old('name', $room->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Room Type --}}
                        <div class="mb-3">
                            <label for="type" class="form-label">Room Type</label>
                            <select class="form-control @error('type') is-invalid @enderror" id="type" name="type"
                                required>
                                <option disabled>Select type</option>
                                <option value="standard" {{ old('type', $room->type) == 'standard' ? 'selected' : '' }}>
                                    Standard
                                </option>
                                <option value="deluxe" {{ old('type', $room->type) == 'deluxe' ? 'selected' : '' }}>
                                    Deluxe
                                </option>
                                <option value="suite" {{ old('type', $room->type) == 'suite' ? 'selected' : '' }}>
                                    Suite
                                </option>
                            </select>
                            @error('type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Price --}}
                        <div class="mb-3">
                            <label for="price" class="form-label">Price Per Night</label>
                            <input type="number" min="1" class="form-control @error('price') is-invalid @enderror"
                                id="price" name="price" value="{{ old('price', $room->price) }}" required>
                            @error('price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Capacity --}}
                        <div class="mb-3">
                            <label for="capacity" class="form-label">Capacity</label>
                            <input type="number" min="1"
                                class="form-control @error('capacity') is-invalid @enderror" id="capacity" name="capacity"
                                value="{{ old('capacity', $room->capacity) }}" required>
                            @error('capacity')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- File Upload --}}
                        <div class="mb-3">
                            <label for="files">Add Images</label>
                            <input type="file" name="file" id="files"
                                class="form-control @error('uploaded_files') is-invalid @enderror" multiple>
                            @error('uploaded_files')
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
                                            {{-- Preview --}}
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
                                                    <a href="{{ $file['url'] }}" download
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

                        <div class="text-center mt-4">
                            <button type="submit" class="btn btn-primary">Update</button>
                            @role('admin')
                                <a href="{{ route('rooms.index') }}" class="btn btn-secondary">Cancel</a>
                            @endrole
                            @role('hotel_manager')
                                <a href="{{ route('manager.rooms.index') }}" class="btn btn-secondary">Cancel</a>
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

                    fetch(`/rooms/${mediaId}/delete`, {
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
