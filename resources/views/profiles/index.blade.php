@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <!-- Profile Picture Section -->
        <div class="col-md-4 col-sm-12 text-center pt-3">
            <img 
                src="{{ $user->profile->profileImage() }}" 
                alt="Profile Picture" 
                class="rounded-circle img-fluid mb-3" 
                style="max-width: 200px">
        </div>

        <!-- Profile Info Section -->
        <div class="col-md-8 col-sm-12 pt-3">
            <div class="d-flex flex-column gap-3">
                <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center">
                    <h1 class="mb-2 mb-sm-0">{{ $user->username }}</h1>
                    @if (auth()->id() !== $user->id)
                        <follow-button user-id="{{$user->id}}" follows="{{$follows}}"></follow-button>
                    @endif
                </div>

                <!-- Buttons Section -->
                <div class="d-flex flex-column flex-sm-row gap-2">
                    @can('update', $user->profile)
                        <a href="/p/create" class="btn btn-outline-primary w-100 w-sm-auto">Add New Post</a>
                        <a href="/profile/{{ $user->id }}/edit" class="btn btn-outline-secondary w-100 w-sm-auto">Edit Profile</a>
                    @endcan
                </div>

                <!-- Profile Statistics -->
                <div class="d-flex justify-content-between justify-content-sm-start gap-3 mt-3">
                    <div><strong>{{ $user->posts->count() }}</strong> posts</div>
                    <div><strong>{{$user->profile->followers->count()}}</strong> followers</div>
                    <div><strong>{{$user->following->count()}}</strong> following</div>
                </div>

                <!-- Profile Description -->
                <div class="mt-4">
                    <div class="font-weight-bold">{{ $user->profile->title }}</div>
                    <div>{{ $user->profile->description }}</div>
                    <a href="{{ $user->profile->url }}" target="_blank">{{ $user->profile->url }}</a>
                </div>
            </div>
        </div>
    </div>

    <!-- User's Posts Section -->
    <div class="row pt-4">
        @foreach($user->posts as $post)
            <div class="col-12 col-sm-6 col-md-4 pb-4">
                <a href="/p/{{ $post->id }}">
                    <img 
                        src="/storage/{{ $post->image }}" 
                        class="w-100 img-fluid" 
                        alt="Post Image">
                </a>
            </div>
        @endforeach
    </div>
</div>
@endsection
