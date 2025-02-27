<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // ログイン処理
    public function showLoginForm()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        // バリデーション(フォームリクエストに書き換え可)
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // ログイン情報が正しいか
        // Auth::attemptメソッドでログイン情報が正しいか検証
        if (Auth::attempt($credentials)) {
            // セッションを再生成する処理(セキュリティ対策)
            $request->session()->regenerate();

            // ミドルウェアに対応したリダイレクト(後述)
            // 下記はredirect('/admin/blogs')に類似
            // intendedメソッドはリダイレクト先のURLを指定するメソッド,
            // 例)ログインしていない状態でブログの編集ページに行こうとするとログイン画面に戻される。
            // その後ログインするとブログの編集ページにリダイレクトされる。
            return redirect()->intended('/admin/blogs');
        }

        // ログイン情報が正しくない場合のみ実行される処理(return すると以降の処理は実行されないため)
        // 一つ前のページ(ログイン画面)にリダイレクト
        // その際にwithErrorsを使ってエラーメッセージで手動で指定する
        // リダイレクト後のビュー内でold関数によって直前の入力内容を取得出来る項目をonlyInputで指定する
        return back()->withErrors([
            'email' => 'メールアドレスまたはパスワードが正しくありません',
        ])->onlyInput('email');
    }

    // ログアウト処理
    public function logout(Request $request)
    {
        // ログアウト処理
        Auth::logout();
        // 現在使っているセッションを無効化(セキュリティ対策のため)
        $request->session()->invalidate();
        // セッションを無効化を再生成(セキュリティ対策のため)
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }
}
