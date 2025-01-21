<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = ['post_id', 'user_id', 'parent_id', 'content', 'likes', 'likes_count'];

    protected $casts = [
        'likes' => 'array', // Automatically cast JSON to array
    ];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function parent()
    {
        return $this->belongsTo(Comment::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Comment::class, 'parent_id');
    }

    public function toggleLike($userId)
    {
        $likes = $this->likes ?? [];

        if (in_array($userId, $likes)) {
            $likes = array_diff($likes, [$userId]);
            $this->likes_count--;
        } else {
            $likes[] = $userId;
            $this->likes_count++;
        }

        $this->likes = array_values($likes);
        $this->save();
    }
}
