@extends('layouts.admin')
@section('title', 'Duyuru / Yazı Ekle')

@section('content')
<div class="max-w-2xl">
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
        <form action="{{ route('admin.announcements.store') }}" method="POST" class="space-y-4">
            @csrf
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="text-xs text-gray-500 mb-1.5 block font-medium">Kategori *</label>
                    <select name="category" required class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-brand">
                        <option value="duyuru">Duyurular</option>
                        <option value="baskan">Başkandan</option>
                        <option value="yazi">Yazılar</option>
                    </select>
                </div>
                <div>
                    <label class="text-xs text-gray-500 mb-1.5 block font-medium">Tarih</label>
                    <input type="date" name="published_at" value="{{ old('published_at', today()->toDateString()) }}"
                        class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-brand">
                </div>
            </div>
            <div>
                <label class="text-xs text-gray-500 mb-1.5 block font-medium">Başlık *</label>
                <input type="text" name="title" required value="{{ old('title') }}"
                    class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-brand">
            </div>
            <div>
                <label class="text-xs text-gray-500 mb-1.5 block font-medium">Özet</label>
                <textarea name="excerpt" rows="2"
                    class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-brand resize-none">{{ old('excerpt') }}</textarea>
            </div>
            <div>
                <label class="text-xs text-gray-500 mb-1.5 block font-medium">İçerik</label>
                <textarea name="content" rows="8"
                    class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-brand resize-none">{{ old('content') }}</textarea>
            </div>
            <div>
                <label class="text-xs text-gray-500 mb-1.5 block font-medium">Kaynak URL</label>
                <input type="url" name="source_url" value="{{ old('source_url') }}"
                    class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-brand">
            </div>
            <div class="flex items-center gap-2">
                <input type="checkbox" name="is_published" id="pub" value="1" checked class="w-4 h-4 accent-brand">
                <label for="pub" class="text-sm text-gray-600">Hemen yayınla</label>
            </div>
            <div class="flex gap-3">
                <button type="submit" class="bg-brand text-white px-5 py-2 rounded-lg text-sm font-medium hover:bg-brand-light transition">Kaydet</button>
                <a href="{{ route('admin.announcements.index') }}" class="border border-gray-200 text-gray-600 px-5 py-2 rounded-lg text-sm hover:border-gray-300 transition">İptal</a>
            </div>
        </form>
    </div>
</div>
@endsection
