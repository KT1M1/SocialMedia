<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class PostsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $users = auth()->user()->following()->pluck('profiles.user_id');

        $posts = Post::whereIn('user_id', $users)->latest()->paginate(5);

        return view('posts.index', compact('posts'));
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store(Request $request)
    {
        // Validate the incoming request
        $data = $request->validate([
            'caption' => 'required',
            'image' => ['required', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ]);

        // Store the uploaded image
        $imagePath = $request->file('image')->store('uploads', 'public');

        $manager = new ImageManager(new Driver());
        $image = $manager->read(public_path("storage/{$imagePath}"));

        // Crop the image
        $image->cover(1600, 1600);

        // Save the processed image
        $image->toJpeg()->save(public_path("storage/{$imagePath}"));

        auth()->user()->posts()->create([
            'caption' => $data['caption'],
            'image' => $imagePath,
        ]);

        return redirect('/profile/' . auth()->user()->id);
    }

    public function show(Post $post)
    {
        return view('posts.show', compact('post'));
    }

    public function destroy(Post $post)
    {
        if (auth()->id() !== $post->user_id) {
            abort(403, 'Unauthorized action.');
        }

        // Delete the post's associated image from storage after post deletion
        $imagePath = $post->image;
        if ($imagePath && file_exists(public_path("storage/{$imagePath}"))) {
            unlink(public_path("storage/{$imagePath}"));
        }

        $post->delete();

        return redirect('/profile/' . auth()->id())->with('success', 'Post deleted successfully.');
    }

    public function like(Post $post)
    {
        $user = auth()->user();

        $isLiked = $post->likes()->where('user_id', $user->id)->exists();

        if ($isLiked) {
            $post->likes()->where('user_id', $user->id)->delete(); // Unlike
        } else {
            $post->likes()->create(['user_id' => $user->id]); // Like
        }

        // Update like count
        return response()->json([
            'likes_count' => $post->likes()->count(),
        ]);
    }
}
