<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ContactController extends Controller
{
    public function index()
    {
        return view("contact.index");
    }

    // メール送信処理
    function sendMail(ContactRequest $request)
    {
        $validated = $request->validated();

        // これ以降の行は入力エラーがなかった場合のみ実行されます
        Log::debug($validated["name"] . "さんよりお問い合わせがありました");
        return to_route("contact.complete");
    }

    public function complete()
    {
        return view("contact.complete");
    }
}
