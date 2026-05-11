@extends('layouts.admin')
@section('title', 'Yeni Yazı Ekle')

@section('content')
<div class="max-w-2xl">
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
        <form action="{{ route('admin.editor.store') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="text-xs text-gray-500 mb-1.5 block font-medium">Başlık *</label>
                <input type="text" name="title" required value="{{ old('title') }}"
                    class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-brand">
            </div>
            <div>
                <label class="text-xs text-gray-500 mb-1.5 block font-medium">Resim URL (opsiyonel)</label>
                <input type="url" name="image" value="{{ old('image') }}"
                    class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-brand"
                    placeholder="https://...">
            </div>
            <div>
                <label class="text-xs text-gray-500 mb-1.5 block font-medium">Özet (boş bırakılırsa içerikten alınır)</label>
                <textarea name="excerpt" rows="2"
                    class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-brand resize-none">{{ old('excerpt') }}</textarea>
            </div>
            <div>
                <label class="text-xs text-gray-500 mb-1.5 block font-medium">İçerik *</label>
                <p class="text-xs text-gray-400 mb-1">Paragrafları boş satırla ayırın. "..." ile başlayan satırlar alıntı görünür.</p>
                <textarea name="content" rows="12" required
                    class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-brand resize-none font-mono">{{ old('content') }}</textarea>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="text-xs text-gray-500 mb-1.5 block font-medium">Yayın Tarihi</label>
                    <input type="datetime-local" name="published_at" value="{{ old('published_at', now()->format('Y-m-d\TH:i')) }}"
                        class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-brand">
                </div>
                <div class="flex items-end pb-1">
                    <div class="flex items-center gap-2">
                        <input type="checkbox" name="is_published" id="pub" value="1" checked class="w-4 h-4 accent-brand">
                        <label for="pub" class="text-sm text-gray-600">Hemen yayınla</label>
                    </div>
                </div>
            </div>
            <div class="flex gap-3">
                <button type="submit" class="bg-brand text-white px-5 py-2 rounded-lg text-sm font-medium hover:bg-brand-light transition">Kaydet</button>
                <a href="{{ route('admin.editor.index') }}" class="border border-gray-200 text-gray-600 px-5 py-2 rounded-lg text-sm hover:border-gray-300 transition">İptal</a>
            </div>
        </form>
    </div>
</div>
@endsection
