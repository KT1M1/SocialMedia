<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\ProfilesController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/p/create', [PostsController::class, 'create'])->name('posts.create');

Route::get('/p/{post}', [PostsController::class, 'show'])->name('posts.show');

Route::post('/p', [PostsController::class, 'store'])->name('posts.store');

Route::get('/profile/{user}', [ProfilesController::class, 'index'])->name('profile.show');