<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SettingController extends Controller
{
    private array $keys = [
        'site_name', 'site_description', 'site_contact', 'footer_text', 'about_text',
        'shoutcast_url', 'shoutcast_sid',
        'prayer_city', 'prayer_country', 'prayer_method',
        'facebook_url', 'twitter_url', 'instagram_url', 'youtube_url',
        'contact_email', 'contact_phone', 'contact_whatsapp',
    ];

    public function index()
    {
        $settings = [];
        foreach ($this->keys as $key) {
            $settings[$key] = Setting::get($key);
        }
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $data = $request->only($this->keys);
        Setting::setMany($data);

        // Şifre değiştirme artık Yöneticiler bölümünden yapılıyor

        return back()->with('success', 'Ayarlar kaydedildi.');
    }
}
