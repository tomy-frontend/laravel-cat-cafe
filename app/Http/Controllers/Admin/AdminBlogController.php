<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreBlogRequest;
use App\Http\Requests\Admin\UpdateBlogRequest;
use App\Models\Blog;
use Illuminate\Support\Facades\Storage;

class AdminBlogController extends Controller
{
    // ブログ一覧画面の表示
    public function index()
    {
        // データベースからupdated_atで並べて昇順に10件表示、ページネーション設置
        $blogs = Blog::latest('updated_at')->limit(10)->simplePaginate(10);
        // ブログ一覧画面にブログデータを渡す
        return view("admin.blogs.index", ['blogs' => $blogs]);
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

    // 指定したIDのブログ編集画面
    public function edit(Blog $blog)
    {
        return view("admin.blogs.edit", ['blog' => $blog]);
    }

    // 指定したIDのブログの更新処理
    public function update(UpdateBlogRequest $request, string $id)
    {
        $blog = Blog::findOrFail($id);
        $updateData = $request->validated();

        // 画像を変更する場合
        if ($request->hasFile('image')) {
            // 変更前の画像を削除
            Storage::disk('public')->delete($blog->image);
            $updateData['image'] = $request->file('image')->store('blogs', 'public');
        }
        $blog->update($updateData);

        return to_route("admin.blogs.index")->with("success", "ブログを更新しました。");
    }

    // 指定したIDのブログの削除処理
    public function destroy(string $id)
    {
        $blog = Blog::findOrFail($id);
        Storage::disk('public')->delete($blog->image);
        $blog->delete();
        return to_route("admin.blogs.index")->with("success", "ブログを削除しました。");
    }
}
