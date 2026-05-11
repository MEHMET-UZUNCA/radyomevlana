@extends('layouts.admin')
@section('title', 'Yöneticiler')

@section('content')
<div class="flex justify-end mb-5">
    <a href="{{ route('admin.users.create') }}"
       class="text-xs bg-brand text-white px-4 py-2 rounded-lg hover:bg-brand-light transition flex items-center gap-1.5">
        <i class="fa-solid fa-plus"></i> Yeni Yönetici
    </a>
</div>

<div class="space-y-3">
    @foreach($users as $user)
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-5 flex items-center gap-4">
        <div class="w-10 h-10 rounded-full bg-brand flex items-center justify-center shrink-0">
            <span class="text-white font-bold text-sm">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
        </div>
        <div class="flex-1">
            <div class="flex items-center gap-2">
                <span class="font-semibold text-gray-800">{{ $user->name }}</span>
                @if($user->id === session('admin_user_id'))
                <span class="text-xs bg-brand/10 text-brand px-1.5 py-0.5 rounded">Siz</span>
                @endif
                @if(!$user->is_active)
                <span class="text-xs bg-red-50 text-red-500 px-1.5 py-0.5 rounded">Pasif</span>
                @endif
            </div>
            <div class="text-xs text-gray-400 mt-0.5">
                {{ '@'.$user->username }} &nbsp;·&nbsp;
                Son giriş: {{ $user->last_login_at?->format('d.m.Y H:i') ?? 'Hiç' }}
            </div>
        </div>
        <div class="flex gap-1">
            <a href="{{ route('admin.users.edit', $user) }}"
               class="text-xs px-2 py-1 rounded border border-gray-200 hover:border-brand hover:text-brand transition">Düzenle</a>
            @if($user->id !== session('admin_user_id') && $users->count() > 1)
            <form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('Bu yönetici silinsin mi?')">
                @csrf @method('DELETE')
                <button class="text-xs px-2 py-1 rounded border border-red-200 text-red-500 hover:bg-red-50 transition">Sil</button>
            </form>
            @endif
        </div>
    </div>
    @endforeach
</div>
@endsection
