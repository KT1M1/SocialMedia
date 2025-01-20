<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Post;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->input('query');

        try {
            // Search for name or username
            $users = User::where('name', 'LIKE', "%$query%")
                ->orWhere('username', 'LIKE', "%$query%")
                ->with('profile') // Redirect to profile
                ->get(['id', 'name', 'username'])
                ->map(function ($user) {
                    return [
                        'id' => $user->id,
                        'name' => $user->name,
                        'username' => $user->username,
                        'image' => $user->profile ? $user->profile->image : 'default.png',
                    ];
                });

            return response()->json(['results' => $users], 200);
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }
}
