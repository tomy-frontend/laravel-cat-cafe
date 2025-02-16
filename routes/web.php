<?php

use App\Http\Controllers\ContactController;
use Illuminate\Support\Facades\Route;

// ルートディレクトリ
Route::view('/', 'index');

// contactページ
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'sendMail']);
Route::get('/contact/complete', [ContactController::class, 'complete'])->name('contact.complete');
