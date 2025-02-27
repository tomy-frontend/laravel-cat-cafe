<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // リダイレクト先のルート名を指定
        // すでにログインしている場合はブログ一覧ページにリダイレクト、メソッドチェーンを利用することも可能
        $middleware
            ->redirectGuestsTo(fn() => route('admin.login'))
            ->redirectUsersTo(fn() => route('admin.blogs.index'));
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
