<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminUser;
use Illuminate\Http\Request;

class AdminUserController extends Controller
{
    public function index()
    {
        $users = AdminUser::orderBy('name')->get();
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:100',
            'username' => 'required|string|max:50|unique:admin_users,username',
            'password' => 'required|string|min:6|confirmed',
        ]);

        AdminUser::create([
            'name'      => $request->name,
            'username'  => $request->username,
            'password'  => $request->password,
            'is_active' => $request->boolean('is_active', true),
        ]);

        return redirect()->route('admin.users.index')->with('success', 'Yönetici oluşturuldu.');
    }

    public function edit(AdminUser $adminUser)
    {
        return view('admin.users.edit', compact('adminUser'));
    }

    public function update(Request $request, AdminUser $adminUser)
    {
        $rules = [
            'name'     => 'required|string|max:100',
            'username' => 'required|string|max:50|unique:admin_users,username,' . $adminUser->id,
        ];

        if ($request->filled('password')) {
            $rules['password'] = 'required|string|min:6|confirmed';
        }

        $request->validate($rules);

        $data = [
            'name'      => $request->name,
            'username'  => $request->username,
            'is_active' => $request->boolean('is_active'),
        ];

        if ($request->filled('password')) {
            $data['password'] = $request->password;
        }

        $adminUser->update($data);
        return redirect()->route('admin.users.index')->with('success', 'Yönetici güncellendi.');
    }

    public function destroy(AdminUser $adminUser)
    {
        if (AdminUser::count() <= 1) {
            return back()->with('error', 'Son yönetici silinemez.');
        }
        if ($adminUser->id === session('admin_user_id')) {
            return back()->with('error', 'Kendi hesabınızı silemezsiniz.');
        }
        $adminUser->delete();
        return back()->with('success', 'Yönetici silindi.');
    }
}
