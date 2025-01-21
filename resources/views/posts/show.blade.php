@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <!-- Post Details Section -->
        <div class="col-12 col-md-8 mb-3 mb-md-0">
            <!-- User Profile and Action Buttons -->
            <div class="d-flex align-items-center mb-3">
                <!-- Profile Image -->
                <div>
                    <img src="{{ $post->user->profile->profileImage() }}" alt="profile image" class="rounded-circle" style="width: 40px; height: 40px;">
                </div>
                <!-- Username and Action Buttons -->
                <div class="ms-2 d-flex align-items-center">
                    <h6 class="m-0">
                        <a href="/profile/{{ $post->user->id }}" class="text-decoration-none text-dark">
                            {{ $post->user->username }}
                        </a>
                    </h6>

                    <!-- Delete Button or Follow Button -->
                    @if (auth()->id() === $post->user->id)
                        <!-- Delete Post -->
                        <form action="{{ route('posts.destroy', $post->id) }}" method="POST" class="ms-2">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" style="margin-left: 10px">Delete Post</button>
                        </form>
                    @else
                        <!-- Follow Button -->
                        <div class="ms-2">
                            <follow-button user-id="{{ $post->user->id }}"
                                follows="{{ auth()->user() ? auth()->user()->following->contains($post->user->id) : false }}">
                            </follow-button>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Post Image -->
        <div class="col-12 col-md-8 mb-3 mb-md-0">
            <img src="/storage/{{ $post->image }}" class="img-fluid rounded" alt="Post Image">
        </div>

        <!-- Post Caption and Details -->
        <div class="col-12 col-md-8 mt-3">
            <p>
                <a href="/profile/{{ $post->user->id }}" class="text-decoration-none text-dark fw-bold">
                    {{ $post->user->username }}
                </a>
                {{ $post->caption }}
            </p>

            <hr>

            <!-- Like Button -->
            <like-button 
                post-id="{{ $post->id }}"
                :is-liked="{{ auth()->user() && $post->likes->contains('user_id', auth()->id()) ? 'true' : 'false' }}"
                :initial-likes-count="{{ $post->likes->count() }}">
            </like-button>

            <hr>

            <!-- Comments Section -->
            <comment-section :post-id="{{ $post->id }}" :user-id="{{ auth()->id() }}"></comment-section>

            <p class="text-muted mt-2">
                Posted on {{ $post->created_at->format('M d, Y H:i') }}
            </p>
        </div>
    </div>
</div>
@endsection