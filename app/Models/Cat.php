<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cat extends Model
{
    // Blogとのリレーション
    public function blogs()
    {
        return $this->belongsToMany(Blog::class);
    }
}
