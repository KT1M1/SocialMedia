@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-3 pt-5">
            <img 
                src="{{ $user->profile->profileImage() }}" 
                alt="Profile Picture" 
                class="rounded-circle" 
                style="max-width: 300px">
        </div>
        <div class="col-9 pt-5">
            <div class="d-flex justify-content-between align-items-baseline">
                <div class="d-flex">
                    <h1>{{ $user->username }}</h1>

                    <follow-button user-id="{{$user->id}}" follows="{{$follows}}"></follow-button>
                </div>

                <!-- Add New Post Button -->
                @can('update', $user->profile)
                    <a href="/p/create" class="btn btn-outline-primary">Add New Post</a>
                @endcan
            </div>

            @can('update', $user->profile)
                <a href="/profile/{{ $user->id }}/edit" class="btn btn-outline-secondary mt-2">Edit Profile</a>
            @endcan

            <!-- Profile Statistics -->
            <div class="d-flex pt-3">
                <div style="padding-right: 10px">
                    <strong>{{ $user->posts->count() }}</strong> posts
                </div>
                <div style="padding-right: 10px">
                    <strong>{{$user->profile->followers->count()}}</strong> followers
                </div>
                <div style="padding-right: 10px">
                    <strong>{{$user->following->count()}}</strong> following
                </div>
            </div>

            <!-- Profile Description -->
            <div class="pt-4 font-weight-bold">{{ $user->profile->title }}</div>
            <div>{{ $user->profile->description }}</div>
            <a href="{{ $user->profile->url }}" target="_blank">{{ $user->profile->url }}</a>
        </div>
    </div>

    <!-- User's Posts Section -->
    <div class="row pt-4">
        @foreach($user->posts as $post)
            <div class="col-4 pb-4">
                <a href="/p/{{ $post->id }}">
                    <img 
                        src="/storage/{{ $post->image }}" 
                        class="w-100" 
                        alt="Post Image">
                </a>
            </div>
        @endforeach
    </div>
</div>
@endsection
