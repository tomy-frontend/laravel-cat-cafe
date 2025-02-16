<?php

use Illuminate\Support\Facades\Route;

// ルートディレクトリ
Route::get('/', function () {
    return view('welcome');
});
