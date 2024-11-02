@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-3 pt-5">
            <img src="https://img.freepik.com/free-photo/3d-snow-grunge-texture-background_1048-11509.jpg?t=st=1730574940~exp=1730578540~hmac=345f2f8333b00c26cdc0202d8a6afeaa0fb18eee12d5c88e7e64d8366fd0e493&w=1060" style="img-flex; border-radius: 50%; max-width: 300px" alt="">
        </div>
        <div class="col-9 pt-5">
            <div>
                <h1>{{$user->username}}</h1>
                <a href="#">Add new Post</a>
            </div>
            <div class="d-flex">
                <div style="padding-right: 10px"><strong>153</strong> posts</div>
                <div style="padding-right: 10px"><strong>23k</strong> followers</div>
                <div style="padding-right: 10px"><strong>18k</strong> following</div>
            </div>
            <div class="pt-4 b">{{$user->profile->title}}</div>
            <div>{{$user->profile->description}}</div>
            <a href="#">{{$user->profile->url}}</a>
        </div>
    </div>
    <div class="row pt-4">
        <div class="col-4">
            <img src="https://img.freepik.com/free-photo/3d-snow-grunge-texture-background_1048-11509.jpg?t=st=1730574940~exp=1730578540~hmac=345f2f8333b00c26cdc0202d8a6afeaa0fb18eee12d5c88e7e64d8366fd0e493&w=1060" class="w-100" alt="" srcset="">
        </div>
        <div class="col-4">
            <img src="https://img.freepik.com/free-photo/3d-snow-grunge-texture-background_1048-11509.jpg?t=st=1730574940~exp=1730578540~hmac=345f2f8333b00c26cdc0202d8a6afeaa0fb18eee12d5c88e7e64d8366fd0e493&w=1060" class="w-100" alt="" srcset="">
        </div>
        <div class="col-4">
            <img src="https://img.freepik.com/free-photo/3d-snow-grunge-texture-background_1048-11509.jpg?t=st=1730574940~exp=1730578540~hmac=345f2f8333b00c26cdc0202d8a6afeaa0fb18eee12d5c88e7e64d8366fd0e493&w=1060" class="w-100" alt="" srcset="">
        </div>
    </div>
    
</div>
@endsection
