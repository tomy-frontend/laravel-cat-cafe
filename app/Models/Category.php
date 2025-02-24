<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{

    // ブログとのリレーション、カテゴリーは複数のブログを持つ、１対多の多数側の設定
    public function blogs()
    {
        return $this->hasMany(Blog::class);
    }
}
