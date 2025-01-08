@extends('layouts.app')

@section('content')
<div class="container py-4">
    @foreach($posts as $post)
    <!-- Post Section -->
    <div class="row mb-5">
        <!-- Post Header: User Profile -->
        <div class="col-12 col-md-8 offset-md-2">
            <div class="d-flex align-items-center mb-2">
                <div>
                    <a href="/profile/{{ $post->user->id }}">
                        <img src="{{ $post->user->profile->profileImage() }}" alt="profile image" class="rounded-circle" style="width:40px; height:40px;">
                    </a>
                </div>
                <div class="ms-2">
                    <a href="/profile/{{ $post->user->id }}" class="text-decoration-none text-dark fw-bold">
                        {{ $post->user->username }}
                    </a>
                </div>
            </div>
        </div>

        <!-- Post Image -->
        <div class="col-12 col-md-8 offset-md-2">
            <a href="/p/{{ $post->id }}">
                <img src="/storage/{{ $post->image }}" class="img-fluid rounded" alt="Post Image">
            </a>
        </div>

        <!-- Post Caption -->
        <div class="col-12 col-md-8 offset-md-2 mt-2">
            <p class="m-0">
                <a href="/profile/{{ $post->user->id }}" class="text-decoration-none text-dark fw-bold">
                    {{ $post->user->username }}
                </a>
                {{ $post->caption }}
            </p>
        </div>
    </div>
    @endforeach

    <!-- Pagination -->
    <div class="row mt-4">
        <div class="col-12 d-flex justify-content-center">
            {{ $posts->links() }}
        </div>
    </div>
</div>
@endsection
