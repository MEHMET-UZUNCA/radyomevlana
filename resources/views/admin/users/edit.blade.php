@extends('layouts.admin')
@section('title', 'Yönetici Düzenle')

@section('content')
<div class="max-w-lg">
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
        <form action="{{ route('admin.users.update', $adminUser) }}" method="POST" class="space-y-4">
            @csrf @method('PUT')

            <div>
                <label class="text-xs text-gray-500 mb-1.5 block font-medium">Ad Soyad *</label>
                <input type="text" name="name" required value="{{ old('name', $adminUser->name) }}"
                    class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-brand">
                @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="text-xs text-gray-500 mb-1.5 block font-medium">Kullanıcı Adı *</label>
                <input type="text" name="username" required value="{{ old('username', $adminUser->username) }}"
                    class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-brand font-mono">
                @error('username')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="text-xs text-gray-500 mb-1.5 block font-medium">Yeni Şifre <span class="text-gray-400">(boş bırakın değişmesin)</span></label>
                <input type="password" name="password"
                    class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-brand">
                @error('password')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="text-xs text-gray-500 mb-1.5 block font-medium">Şifre Tekrar</label>
                <input type="password" name="password_confirmation"
                    class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-brand">
            </div>

            <div class="flex items-center gap-2">
                <input type="checkbox" name="is_active" id="is_active" value="1"
                       {{ old('is_active', $adminUser->is_active) ? 'checked' : '' }} class="w-4 h-4 accent-brand">
                <label for="is_active" class="text-sm text-gray-600">Aktif</label>
            </div>

            <div class="flex gap-3">
                <button type="submit" class="bg-brand text-white px-5 py-2 rounded-lg text-sm font-medium hover:bg-brand-light transition">Güncelle</button>
                <a href="{{ route('admin.users.index') }}" class="border border-gray-200 text-gray-600 px-5 py-2 rounded-lg text-sm hover:border-gray-300 transition">İptal</a>
            </div>
        </form>
    </div>
</div>
@endsection
