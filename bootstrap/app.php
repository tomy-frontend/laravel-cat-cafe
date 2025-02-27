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
        $middleware->redirectGuestsTo(fn() => route('admin.login'));
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
