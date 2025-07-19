<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactNotification;

class ContactController extends Controller
{
    public function show()
    {
        return view('client.pages.contact');
    }

    public function send(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'message' => 'required|string|min:5',
        ]);

        Mail::to('lesang0905000@gmail.com')->send(new ContactNotification($data));

        return back()->with('success', 'Bạn đã gửi liên hệ thành công!');
    }

    public function subscribe(Request $request)
    {
        // Xử lý đăng ký newsletter (nếu cần)
        return back()->with('success', 'Đăng ký nhận tin thành công!');
    }
}


