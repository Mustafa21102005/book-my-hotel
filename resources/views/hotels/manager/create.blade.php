@extends('layouts.dashboard')

@section('title', 'Create Hotel')

@section('page-header', 'Create Hotel')

@section('content')
    <x-error-alert />

    <div class="row">
        <div class="col-12">
            <div class="card">
                <h5 class="card-header">Create Hotel</h5>
                <div class="card-body">
                    <form action="{{ route('hotels.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="name" class="form-label">Hotel Name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                name="name" value="{{ old('name') }}" required autofocus>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                                rows="3">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="region" class="form-label">Region</label>
                            <select name="region" id="region" class="form-control @error('region') is-invalid @enderror"
                                required>
                                <option selected disabled>Select a region</option>
                                <option value="asia" {{ old('region') == 'Asia' ? 'selected' : '' }}>Asia</option>
                                <option value="europe" {{ old('region') == 'Europe' ? 'selected' : '' }}>Europe</option>
                            </select>
                            @error('region')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="country" class="form-label">Country</label>
                            <input type="text" class="form-control @error('country') is-invalid @enderror" id="country"
                                name="country" value="{{ old('country') }}" required>
                            @error('country')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="city" class="form-label">City</label>
                            <input type="text" class="form-control @error('city') is-invalid @enderror" id="city"
                                name="city" value="{{ old('city') }}" required>
                            @error('city')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="street" class="form-label">Street</label>
                            <input type="text" class="form-control @error('street') is-invalid @enderror" id="street"
                                name="street" value="{{ old('street') }}" required>
                            @error('street')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <input type="file" id="files" name="file"
                                class="form-control @error('uploaded_files') is-invalid @enderror" multiple required
                                enctype="multipart/form-data">
                            @error('uploaded_files')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- For Filepond --}}
                        <input type="hidden" name="uploaded_files" id="uploaded_files">

                        <div class="mb-3">

                            <label class="form-label">Hotel Features</label>

                            <div class="form-check">
                                <input class="form-check-input @error('breakfast') is-invalid @enderror" type="checkbox"
                                    name="breakfast" id="breakfast" value="1" {{ old('breakfast') ? 'checked' : '' }}>
                                <label class="form-check-label" for="breakfast">Breakfast</label>
                                @error('breakfast')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-check">
                                <input class="form-check-input @error('wifi') is-invalid @enderror" type="checkbox"
                                    name="wifi" id="wifi" value="1" {{ old('wifi') ? 'checked' : '' }}>
                                <label class="form-check-label" for="wifi">WiFi</label>
                                @error('wifi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-check">
                                <input class="form-check-input @error('pool') is-invalid @enderror" type="checkbox"
                                    name="pool" id="pool" value="1" {{ old('pool') ? 'checked' : '' }}>
                                <label class="form-check-label" for="pool">Pool</label>
                                @error('pool')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-check">
                                <input class="form-check-input @error('gym') is-invalid @enderror" type="checkbox"
                                    name="gym" id="gym" value="1" {{ old('gym') ? 'checked' : '' }}>
                                <label class="form-check-label" for="gym">Gym</label>
                                @error('gym')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-check">
                                <input class="form-check-input @error('pets_allowed') is-invalid @enderror"
                                    type="checkbox" name="pets_allowed" id="pets_allowed" value="1"
                                    {{ old('pets_allowed') ? 'checked' : '' }}>
                                <label class="form-check-label" for="pets_allowed">Pets Allowed</label>
                                @error('pets_allowed')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-check">
                                <input class="form-check-input @error('environment') is-invalid @enderror"
                                    type="checkbox" name="environment" id="environment" value="1"
                                    {{ old('environment') ? 'checked' : '' }}>
                                <label class="form-check-label" for="environment">Eco-Friendly</label>
                                @error('environment')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">Create</button>
                            <a href="{{ route('manager.hotels.index') }}" class="btn btn-secondary">Cancel</a>
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
            acceptedFileTypes: [
                'image/*'
            ],
            fileValidateTypeLabelExpectedTypesMap: {
                'image/*': 'image'
            },
            labelIdle: 'Drag & Drop files or <span class="filepond--label-action">Browse</span>',
            server: {
                process: {
                    url: '/uploads',
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    withCredentials: false,
                    onload: (response) => {
                        const data = JSON.parse(response);

                        // Save uploaded file info to hidden input
                        let uploaded = document.getElementById('uploaded_files').value;
                        let list = uploaded ? JSON.parse(uploaded) : [];
                        list.push(data);
                        document.getElementById('uploaded_files').value = JSON.stringify(list);

                        return data.folder; // required by FilePond
                    },
                    onerror: (response) => {
                        console.error('Upload failed', response);
                    }
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
                    }).then(() => {
                        load();
                    }).catch(() => {
                        error('Could not revert file');
                    });
                }
            }
        });
    </script>
@endsection
