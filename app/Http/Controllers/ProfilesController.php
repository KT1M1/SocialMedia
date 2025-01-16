<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class ProfilesController extends Controller
{
    public function index(User $user)
    {
        $follows = (auth()->user()) ? auth()->user()->following->contains($user->id) : false;

        return view('profiles.index', compact('user', 'follows'));
    }

    public function edit(User $user)
    {
        $this->authorize('update', $user->profile);

        return view('profiles.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $this->authorize('update', $user->profile);

        // Validate the incoming request
        $data = $request->validate([
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'url' => 'nullable|url',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            // Store the uploaded image
            $imagePath = $request->file('image')->store('profile', 'public');

            // Process the uploaded image
            $manager = new ImageManager(new Driver());
            $image = $manager->read(public_path("storage/{$imagePath}"));

            // Crop to 1:1 ratio from the center
            $image->cover(400, 400);

            // Save the cropped image
            $image->toJpeg()->save(public_path("storage/{$imagePath}"));

            // Delete the old image after the new image has been successfully saved
            $oldImage = $user->profile->image;
            if ($oldImage && $oldImage !== 'default.png' && file_exists(public_path("storage/{$oldImage}"))) {
                unlink(public_path("storage/{$oldImage}"));
            }

            $data['image'] = $imagePath;
        }

        // Update the profile with the provided data
        auth()->user()->profile->update($data);

        return redirect("/profile/{$user->id}");
    }
}
