<?php

use App\Http\Controllers\Admin\AdminBlogController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\ContactController;
use Illuminate\Support\Facades\Route;

// ルートディレクトリ
Route::view("/", "index");

Route::prefix('/contact')
    ->name('contact.')
    ->group(function () {
        // contactページ
        Route::get("/", [ContactController::class, "index"])->name("index");
        Route::post("/", [ContactController::class, "sendMail"]);
        Route::get("/complete", [ContactController::class, "complete"])->name(
            "complete"
        );
    });

// 管理画面
Route::prefix('/admin')
    ->name('admin.')
    ->group(function () {
        // ログイン時のみアクセス可能なルート
        Route::middleware('auth')
            ->group(function () {
                // ブログ
                Route::resource('/blogs', AdminBlogController::class)->except('show');

                // ユーザー管理
                Route::get("/users/create", [UserController::class, "create"])->name("users.create");
                Route::post("/users", [UserController::class, "store"])->name('users.store');

                // ログアウト
                Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
            });

        // 未ログイン時のみアクセス可能なルート
        // 認証
        Route::middleware('guest')
            ->group(function () {
                Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
                Route::post('/login', [AuthController::class, 'login']);
            });
    });
