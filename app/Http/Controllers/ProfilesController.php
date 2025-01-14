<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Intervention\Image\Facades\Image;

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

            // Resize and crop the image using Intervention Image
            $image = \Intervention\Image\ImageManager::gd()
                ->read(public_path("storage/{$imagePath}"))
                ->resize(600, 600, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })
                ->crop(500, 500, (600 - 500) / 2, (600 - 500) / 2);  // Crop from the center
            $image->save();

            $data['image'] = $imagePath;
        }

        // Update the profile with the provided data
        auth()->user()->profile->update($data);

        return redirect("/profile/{$user->id}");
    }
}
