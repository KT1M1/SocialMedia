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

    public function update(User $user)
    {
        $this->authorize('update', $user->profile);

        // Validation: Fields can be nullable to allow clearing them
        $data = request()->validate([
            'title' => 'nullable|string|max:255',   // Title can be cleared
            'description' => 'nullable|string',    // Description can be cleared
            'url' => 'nullable|url',               // URL can be cleared
            'image' => 'nullable|image',           // Image is optional
        ]);

        // Handle image upload (if provided)
        if (request('image')) {
            $imagePath = request('image')->store('profile', 'public');
            $data['image'] = $imagePath;
        }

        // Update the profile with the provided data
        auth()->user()->profile->update($data);

        return redirect("/profile/{$user->id}");
    }
}
