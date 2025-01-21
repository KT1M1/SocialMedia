<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\ProfilesController;
use App\Http\Controllers\FollowsController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\CommentController;

Auth::routes();

Route::post('follow/{user}', [FollowsController::class, 'store'])->name('follow.store');

Route::get('/', [PostsController::class, 'index']);
Route::get('/p/create', [PostsController::class, 'create'])->name('posts.create');
Route::post('/p', [PostsController::class, 'store'])->name('posts.store');
Route::get('/p/{post}', [PostsController::class, 'show'])->name('posts.show');
Route::delete('/p/{post}', [PostsController::class, 'destroy'])->name('posts.destroy');
Route::post('like/{post}', [PostsController::class, 'like'])->name('posts.like');

Route::get('/profile/{user}', [ProfilesController::class, 'index'])->name('profile.show');
Route::get('/profile/{user}/edit', [ProfilesController::class, 'edit'])->name('profile.edit');
Route::patch('/profile/{user}', [ProfilesController::class, 'update'])->name('profile.update');

Route::get('/search', [SearchController::class, 'search'])->name('search');

Route::get('/p/{post}/comments', [CommentController::class, 'index'])->name('comments.index');
Route::post('/p/{post}/comments', [CommentController::class, 'store'])->name('comments.store');
Route::post('/p/comments/{id}/like', [CommentController::class, 'toggleLike'])->name('comments.toggleLike');
Route::delete('/p/comments/{id}', [CommentController::class, 'destroy'])->name('comments.destroy');