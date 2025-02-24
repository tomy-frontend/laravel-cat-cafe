<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;

    // 一括代入を許可する属性(これを指定しない属性は一括代入できない)
    // $fillableはデータベースレベルでの保護
    protected $fillable = ["title", "body", "image"];

    // カテゴリーとのリレーション、ブログは1つのカテゴリーに属する。１対多の１側の設定
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
