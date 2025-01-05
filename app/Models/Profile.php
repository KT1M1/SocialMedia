<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $guarded = [];

    public function profileImage()
    {
        $imagePath = ($this->image) ?  $this -> image : '/profile/ClpvheKzZXcw41pZs5atxDzmvSlzpcy66LiQ2OZi.png';
        return '/storage/' . $imagePath;
    }

    public function followers()
{
    return $this->belongsToMany(User::class, 'profile_user', 'profile_id', 'user_id');
}

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
