<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
     use HasFactory;

    protected $fillable = [
        'user_id', 'text', 'media_path', 'media_type'
    ];

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
