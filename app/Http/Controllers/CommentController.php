<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function index($postId)
    {
        $comments = Comment::where('post_id', $postId)
            ->whereNull('parent_id')
            ->with('children.user', 'user') // Load nested replies and users
            ->get();

        return response()->json($comments);
    }

    public function store(Request $request, $postId)
    {
        $validated = $request->validate([
            'content' => 'required|string|max:1000',
            'parent_id' => 'nullable|exists:comments,id',
        ]);

        $comment = Comment::create([
            'post_id' => $postId,
            'user_id' => auth()->id(),
            'content' => $validated['content'],
            'parent_id' => $validated['parent_id'] ?? null,
        ]);

        return response()->json($comment->load('user'));
    }

    public function toggleLike($id)
    {
        $comment = Comment::findOrFail($id);
        $comment->toggleLike(auth()->id());

        return response()->json($comment);
    }

    public function destroy($id)
    {
        $comment = Comment::findOrFail($id);

        // Ensure the authenticated user is the owner of the comment
        if ($comment->user_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $comment->delete();

        return response()->json(['message' => 'Comment deleted successfully']);
    }
}
