<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminUser;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (session('admin_logged_in')) {
            return redirect()->route('admin.dashboard');
        }
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $user = AdminUser::where('username', $request->username)
            ->where('is_active', true)
            ->first();

        if ($user && $user->checkPassword($request->password)) {
            $user->update(['last_login_at' => now()]);
            session([
                'admin_logged_in' => true,
                'admin_user_id'   => $user->id,
                'admin_user_name' => $user->name,
            ]);
            return redirect()->route('admin.dashboard');
        }

        return back()->withErrors(['username' => 'Kullanıcı adı veya şifre hatalı.']);
    }

    public function logout()
    {
        session()->flush();
        return redirect()->route('admin.login');
    }
}
