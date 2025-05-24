@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-center align-items-center min-vh-100">
        <div class="card shadow-lg p-4 w-100" style="max-width: 800px;">

    <h2>{{ isset($tour) ? 'Edit Tour' : 'Create Tour' }}</h2>

    <form action="{{ isset($tour) ? route('tours.update', $tour->id) : route('tours.store') }}"
          method="POST"
          enctype="multipart/form-data">

        @csrf
        @if(isset($tour))
            @method('PUT')
        @endif

        <div class="row">
            <div class="col-md-4 mb-3">
                <label for="title" class="form-label">Tour Title</label>
                <input type="text" name="title" id="title"
                       class="form-control @error('title') is-invalid @enderror"
                       value="{{ old('title', $tour->title ?? '') }}">
                @error('title')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-4 mb-3">
                <label for="start_date" class="form-label">Start Date</label>
                <input type="date" name="start_date" id="start_date"
                       class="form-control @error('start_date') is-invalid @enderror"
                       value="{{ old('start_date', isset($tour) ? \Carbon\Carbon::parse($tour->start_date)->format('Y-m-d') : '') }}">
                @error('start_date')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-4 mb-3">
                <label for="end_date" class="form-label">End Date</label>
                <input type="date" name="end_date" id="end_date"
                       class="form-control @error('end_date') is-invalid @enderror"
                       value="{{ old('end_date', isset($tour) ? \Carbon\Carbon::parse($tour->end_date)->format('Y-m-d') : '') }}">
                @error('end_date')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-12 mb-3">
                <label for="description" class="form-label">Tour Description</label>
                <textarea name="description" id="description"
                          class="form-control @error('description') is-invalid @enderror"
                          rows="4">{{ old('description', $tour->description ?? '') }}</textarea>
                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <label class="form-label fw-bold">Tour Images</label>
                <div id="image-preview" class="d-flex flex-wrap gap-2 mb-2">

                    @if(isset($tour))
                        @foreach($tour->images as $image)
                            <div class="position-relative m-2 border rounded p-1 shadow-sm bg-light">
                                <img src="{{ asset('storage/' . $image->image_path) }}"
                                     class="img-thumbnail" style="width: 100px; height: 100px; object-fit: cover;">
                                <button type="button"
                                        class="btn-close position-absolute top-0 end-0 bg-white"
                                        onclick="removeExistingImage({{ $image->id }}, this)"></button>
                                <input type="hidden" name="existing_images[]" value="{{ $image->id }}">
                            </div>
                        @endforeach
                    @endif
                    <label for="images" class="btn d-inline-flex align-items-center  align-self-center gap-1 ">
                        <i class="bi bi-plus-circle h-100 w-100 h4"></i>
                    </label>
                </div>

                <input type="file" name="images[]" id="images" class="d-none" multiple accept="image/*" onchange="previewImages()">


                <input type="hidden" name="delete_images[]" id="delete_images_holder" />
                @error('images.*')
                    <div class="text-danger mt-2">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="d-grid mb-3">

        <button type="submit" class="btn btn-primary">
            {{ isset($tour) ? 'Update Tour' : 'Create Tour' }}
        </button>
    </div>
    </form>
</div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    let selectedFiles = new DataTransfer();
    let deleteImageIds = [];

    function previewImages() {
        const input = document.getElementById('images');
        const previewContainer = document.getElementById('image-preview');

        for (let i = 0; i < input.files.length; i++) {
            const file = input.files[i];
            if (!Array.from(selectedFiles.files).some(f => f.name === file.name)) {
                selectedFiles.items.add(file);

                const reader = new FileReader();
                reader.onload = function (e) {
                    const div = document.createElement('div');
                    div.classList.add('position-relative', 'm-2', 'border', 'rounded', 'p-1', 'shadow-sm', 'bg-light');
                    div.innerHTML = `
                        <img src="${e.target.result}" class="img-thumbnail" style="width: 100px; height: 100px; object-fit: cover;">
                        <button type="button" class="btn-close position-absolute top-0 end-0 bg-white" onclick="removeImage('${file.name}', this)"></button>
                    `;
                    previewContainer.appendChild(div);
                };
                reader.readAsDataURL(file);
            }
        }
        input.files = selectedFiles.files;
    }

    function removeImage(fileName, button) {
        const dt = new DataTransfer();
        for (let i = 0; i < selectedFiles.files.length; i++) {
            if (selectedFiles.files[i].name !== fileName) {
                dt.items.add(selectedFiles.files[i]);
            }
        }
        selectedFiles = dt;
        document.getElementById('images').files = selectedFiles.files;
        button.parentElement.remove();
    }

    function removeExistingImage(id, button) {
        deleteImageIds.push(id);
        document.getElementById('delete_images_holder').value = deleteImageIds.join(',');
        button.parentElement.remove();
    }
</script>
@endpush



