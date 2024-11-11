@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-3 pt-5">
            <img src="{{ $user->profile->profileImage() }}" alt="Profile Picture" class="rounded-circle" style="max-width: 300px">
        </div>
        <div class="col-9 pt-5">
            <div class="d-flex justify-content-between align-items-baseline">
                <h1>{{$user->username}}</h1>
                @can('update', $user->profile)
                    <a href="/p/create">Add new Post</a>
                @endcan
            </div>

            @can('update', $user->profile)
                <a href="/profile/{{$user->id}}/edit">Edit Profile</a>
            @endcan

            <div class="d-flex">
                <div style="padding-right: 10px"><strong>{{$user->posts->count()}}</strong> posts</div>
                <div style="padding-right: 10px"><strong>23k</strong> followers</div>
                <div style="padding-right: 10px"><strong>18k</strong> following</div>
            </div>
            <div class="pt-4 b">{{$user->profile->title}}</div>
            <div>{{$user->profile->description}}</div>
            <a href="#">{{$user->profile->url}}</a>
        </div>
    </div>
    <div class="row pt-4">
        @foreach($user->posts as $post)
            <div class="col-4 pb-4">
                <a href="/p/{{$post->id}}">
                    <img src="/storage/{{$post->image}}" class="w-100" alt="" srcset="">
                </a>
            </div>
        @endforeach
    </div>
    
</div>
@endsection
