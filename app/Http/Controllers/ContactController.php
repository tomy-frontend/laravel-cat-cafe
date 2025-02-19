<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest;
use App\Mail\ContactAdminMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

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

        Mail::to(users: 'tomy.webengineer@gmail.com')->send(new ContactAdminMail($validated));
        return to_route("contact.complete");
    }

    public function complete()
    {
        return view("contact.complete");
    }
}
