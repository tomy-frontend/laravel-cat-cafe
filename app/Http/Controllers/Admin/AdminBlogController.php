<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreBlogRequest;
use App\Models\Blog;

class AdminBlogController extends Controller
{
    // ブログ一覧画面
    public function index()
    {
        return view("admin.blogs.index");
    }

    // ブログ投稿画面
    public function create()
    {
        return view("admin.blogs.create");
    }

    // ブログ投稿処理
    public function store(StoreBlogRequest $request)
    {
        // データベースに保存する画像パスを作成
        $savedImagePath = $request
            ->file(key: "image")
            ->store("blogs", "public");

        // 新規ブログインスタンスを作成
        $blog = new Blog($request->validated());
        // 下記状態と同じ、配列で入ってくる// Blog モデルで $fillable プロパティに設定したカラムだけを一括代入できる
        // $request->validated() は StoreBlogRequest のバリデーションをパスしたデータが取得できる
        // title と body のデータが連想配列で返される
        // $blog->title と $blog->body にそれぞれのデータが代入される
        // $blog->title = $validatedData['title'];
        // $blog->body = $validatedData['body'];
        $blog->image = $savedImagePath;
        $blog->save(); // データベースに保存

        return to_route("admin.blogs.index")->with(
            "success",
            "ブログを投稿しました。"
        );
    }
}
