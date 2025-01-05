@extends('layouts.app')

@section('content')
<div class="container">
   @foreach($posts as $post)
   <div class="row">
        <div class="col-6 offset-3">
            <img src="/storage/{{$post->image}}"class="w-100" alt="" srcset="">
        </div>
    </div>
    <div class="row py-2 pb-4">
        <div class="col-6 offset-3">
            <div>
                <p>
                    <a href="/profile/{{$post->user->id}}" class="text-decoration-none text-dark">
                        <span class="fw-bold">{{$post->user->username}}</span>
                    </a>
                    {{$post->caption}}
                </p>
            </div>
        </div>
    </div>
    @endforeach

    <div class="row">
        <div class="col-12 d-flex justify-content-center">
            {{ $posts->links() }}
        </div>
    </div>

</div>
@endsection
