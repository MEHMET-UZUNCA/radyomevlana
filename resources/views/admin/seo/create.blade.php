@extends('layouts.admin')
@section('title', 'Yeni SEO Kaydı')

@section('content')
<div class="max-w-2xl">
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
        <form action="{{ route('admin.seo.store') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label class="text-xs text-gray-500 mb-1.5 block font-medium">Sayfa Yolu (Path) *</label>
                <input type="text" name="path" required value="{{ old('path') }}"
                    class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-brand font-mono"
                    placeholder="/ veya /hutbeler veya /duyurular">
                @error('path')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="text-xs text-gray-500 mb-1.5 block font-medium">Sayfa Başlığı <span class="text-gray-400">(max 120 karakter)</span></label>
                <input type="text" name="title" value="{{ old('title') }}" maxlength="120"
                    class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-brand"
                    placeholder="Radyo Mevlana – İslami Radyo">
            </div>

            <div>
                <label class="text-xs text-gray-500 mb-1.5 block font-medium">Meta Açıklama <span class="text-gray-400">(max 320 karakter)</span></label>
                <textarea name="description" rows="3" maxlength="320"
                    class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-brand resize-none"
                    placeholder="Arama motorlarında görünecek açıklama metni...">{{ old('description') }}</textarea>
            </div>

            <div>
                <label class="text-xs text-gray-500 mb-1.5 block font-medium">Anahtar Kelimeler</label>
                <input type="text" name="keywords" value="{{ old('keywords') }}"
                    class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-brand"
                    placeholder="radyo, islam, mevlana, ezan">
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="text-xs text-gray-500 mb-1.5 block font-medium">OG Başlık (Sosyal medya)</label>
                    <input type="text" name="og_title" value="{{ old('og_title') }}" maxlength="120"
                        class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-brand">
                </div>
                <div>
                    <label class="text-xs text-gray-500 mb-1.5 block font-medium">OG Görsel URL</label>
                    <input type="url" name="og_image" value="{{ old('og_image') }}"
                        class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-brand"
                        placeholder="https://...">
                </div>
            </div>

            <div class="flex gap-3">
                <button type="submit" class="bg-brand text-white px-5 py-2 rounded-lg text-sm font-medium hover:bg-brand-light transition">Kaydet</button>
                <a href="{{ route('admin.seo.index') }}" class="border border-gray-200 text-gray-600 px-5 py-2 rounded-lg text-sm hover:border-gray-300 transition">İptal</a>
            </div>
        </form>
    </div>
</div>
@endsection
