@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-8">
        <img src="/storage/{{$post->image}}"class="w-100" alt="" srcset="">
        </div>
        <div class="col-4">
            <div>
                <div class="d-flex align-items-center">
                    <div class="p-2">
                        <img src="{{$post->user->profile->profileImage()}}" alt="profile image" class="rounded-circle" style="width:50px">
                    </div>
                    <div class="p-2">
                        <h5>
                            <a href="/profile/{{$post->user->id}}" class="text-decoration-none text-dark">
                                <span class="fw-bold">{{$post->user->username}}</span>
                            </a>
                        </h5>
                        <a href="">Follow</a>
                    </div>
                </div>

                <hr>
                
                <p>
                    <a href="/profile/{{$post->user->id}}" class="text-decoration-none text-dark">
                        <span class="fw-bold">{{$post->user->username}}</span>
                    </a>
                    {{$post->caption}}
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
