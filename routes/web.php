<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\ProfilesController;
use App\Http\Controllers\FollowsController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::post('follow/{user}', [FollowsController::class, 'store'])->name('follow.store');

Route::get('/p/create', [PostsController::class, 'create'])->name('posts.create');
Route::post('/p', [PostsController::class, 'store'])->name('posts.store');
Route::get('/p/{post}', [PostsController::class, 'show'])->name('posts.show');

Route::get('/profile/{user}', [ProfilesController::class, 'index'])->name('profile.show');
Route::get('/profile/{user}/edit', [ProfilesController::class, 'edit'])->name('profile.edit');
Route::patch('/profile/{user}', [ProfilesController::class, 'update'])->name('profile.update');