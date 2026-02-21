@extends('layouts.dashboard')

@section('title', 'Create Room')

@section('page-header', 'Create Room')

@section('content')
    <x-error-alert />

    <div class="row">
        <div class="col-12">
            <div class="card">
                <h5 class="card-header">Create Room</h5>
                <div class="card-body">
                    <form action="{{ route('rooms.store') }}" method="POST">
                        @csrf

                        {{-- Room Name --}}
                        <div class="mb-3">
                            <label for="name" class="form-label">Room Name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                name="name" value="{{ old('name') }}" required autofocus>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Room Type --}}
                        <div class="mb-3">
                            <label for="type" class="form-label">Room Type</label>
                            <select class="form-control @error('type') is-invalid @enderror" id="type" name="type"
                                required>
                                <option selected disabled>Select type</option>
                                <option value="standard" {{ old('type') == 'standard' ? 'selected' : '' }}>
                                    Standard
                                </option>
                                <option value="deluxe" {{ old('type') == 'deluxe' ? 'selected' : '' }}>Deluxe</option>
                                <option value="suite" {{ old('type') == 'suite' ? 'selected' : '' }}>Suite</option>
                            </select>
                            @error('type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Price --}}
                        <div class="mb-3">
                            <label for="price" class="form-label">Price Per Night</label>
                            <input type="number" step="0.01" class="form-control @error('price') is-invalid @enderror"
                                id="price" name="price" value="{{ old('price') }}" required>
                            @error('price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Capacity --}}
                        <div class="mb-3">
                            <label for="capacity" class="form-label">Capacity (number of people)</label>
                            <input type="number" min="1"
                                class="form-control @error('capacity') is-invalid @enderror" id="capacity" name="capacity"
                                value="{{ old('capacity', 1) }}" required>
                            @error('capacity')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- File Upload --}}
                        <div class="mb-3">
                            <label class="form-label">Room Images</label>
                            <input type="file" id="files" name="file"
                                class="form-control @error('uploaded_files') is-invalid @enderror" multiple>
                            @error('uploaded_files')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Filepond hidden field --}}
                        <input type="hidden" name="uploaded_files" id="uploaded_files">

                        <div class="text-center mt-4">
                            <button type="submit" class="btn btn-primary">Create</button>
                            <a href="{{ route('manager.rooms.index') }}" class="btn btn-secondary">Cancel</a>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        FilePond.registerPlugin(FilePondPluginFileValidateType);

        const inputElement = document.querySelector('input[type="file"]');

        const pond = FilePond.create(inputElement, {
            allowMultiple: true,
            allowRevert: true,
            allowPreview: true,
            acceptedFileTypes: ['image/*'],
            labelIdle: 'Drag & Drop images or <span class="filepond--label-action">Browse</span>',

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
                    }
                },

                revert: (uniqueFileId, load, error) => {
                    let uploadedInput = document.getElementById('uploaded_files');
                    let list = uploadedInput.value ? JSON.parse(uploadedInput.value) : [];
                    list = list.filter(f => f.folder !== uniqueFileId);
                    uploadedInput.value = JSON.stringify(list);

                    fetch(`/uploads/revert/${uniqueFileId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    }).then(() => load()).catch(() => error('Failed to revert'));
                }
            }
        });
    </script>
@endsection
