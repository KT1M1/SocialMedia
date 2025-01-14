@extends('layouts.app')

@section('content')
<div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
    <div class="col-md-8 text-center">
        <h1>Edit Profile</h1>

        <!-- Profile image preview (initially showing the existing image) -->
        <div class="mb-4">
            <img id="profileImagePreview" src="{{ $user->profile->profileImage() }}" alt="Profile Picture" class="rounded-circle img-fluid mb-3"
                 style="width: 200px; height: 200px; object-fit: cover; max-width: 100%; max-height: 100%; margin: auto;">
        </div>

        <!-- Form for editing profile -->
        <form id="profileForm" action="/profile/{{$user->id}}" enctype="multipart/form-data" method="post">
            @csrf
            @method('PATCH')

            <!-- File input for image upload -->
            <div class="mb-3">
                <label for="image" class="col-md-4 col-form-label">Profile Image</label>
                <input type="file" id="image" name="image" class="form-control" onchange="previewImage(event)">
                <small class="form-text text-muted">Please upload an image with a 1:1 aspect ratio to ensure the picture quality remains optimal.</small>
                @error('image')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Title Field -->
            <div class="mb-3">
                <label for="title" class="col-md-4 col-form-label">Title</label>
                <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title') ?? $user->profile->title }}" autocomplete="title" maxlength="100" autofocus>
                <small class="form-text text-muted">Up to 100 characters allowed.</small>
                @error('title')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Description Field -->
            <div class="mb-3">
                <label for="description" class="col-md-4 col-form-label">Description</label>
                <input id="description" type="text" class="form-control @error('description') is-invalid @enderror" name="description" value="{{ old('description') ?? $user->profile->description }}" autocomplete="description" maxlength="400" autofocus>
                <small class="form-text text-muted">Up to 400 characters allowed.</small>
                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- URL Field -->
            <div class="mb-3">
                <label for="url" class="col-md-4 col-form-label">URL</label>
                <input id="url" type="text" class="form-control @error('url') is-invalid @enderror" name="url" value="{{ old('url')  ?? $user->profile->url}}" autocomplete="url" autofocus>
                @error('url')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Save Button -->
            <div class="row p-4">
                <button class="btn btn-primary w-100">Save Profile</button>
            </div>
        </form>
    </div>
</div>

<script>
    // Handle image preview when a new file is selected
    function previewImage(event) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const imagePreview = document.getElementById('profileImagePreview');
            imagePreview.src = e.target.result; // Update the preview image
            imagePreview.style.display = 'block'; // Show the preview image
        };
        reader.readAsDataURL(event.target.files[0]);
    }
</script>

@endsection
