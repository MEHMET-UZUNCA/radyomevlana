<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        return view('contact.index');
    }

    public function send(Request $request)
    {
        $data = $request->validate([
            'name'    => ['required', 'max:100'],
            'email'   => ['required', 'email', 'max:150'],
            'subject' => ['required', 'max:200'],
            'message' => ['required', 'max:2000'],
        ]);

        $to      = 'mehmetuzunca85@gmail.com';
        $subject = '=?UTF-8?B?' . base64_encode('İletişim Formu: ' . $data['subject']) . '?=';
        $body    = "İsim: {$data['name']}\nE-posta: {$data['email']}\n\nMesaj:\n{$data['message']}";
        $headers = implode("\r\n", [
            'From: Radyo Mevlana <info@radyomevlana.com>',
            'Reply-To: ' . $data['email'],
            'Content-Type: text/plain; charset=UTF-8',
        ]);

        @mail($to, $subject, $body, $headers);

        return back()->with('success', 'Mesajınız başarıyla iletildi. En kısa sürede dönüş yapılacaktır.');
    }
}
