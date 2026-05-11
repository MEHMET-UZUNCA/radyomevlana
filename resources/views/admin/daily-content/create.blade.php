@extends('layouts.admin')
@section('title', 'Yeni İçerik Ekle')

@section('content')
<div class="max-w-2xl">
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
        <form action="{{ route('admin.daily-content.store') }}" method="POST" class="space-y-4">
            @csrf
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="text-xs text-gray-500 mb-1.5 block font-medium">Tür *</label>
                    <select name="type" required class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-brand">
                        <option value="ayet" {{ old('type')=='ayet'?'selected':'' }}>Ayet</option>
                        <option value="hadis" {{ old('type')=='hadis'?'selected':'' }}>Hadis</option>
                        <option value="soz" {{ old('type')=='soz'?'selected':'' }}>Söz</option>
                    </select>
                </div>
                <div>
                    <label class="text-xs text-gray-500 mb-1.5 block font-medium">Tarih *</label>
                    <input type="date" name="date" required value="{{ old('date', today()->toDateString()) }}"
                        class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-brand">
                </div>
            </div>
            <div>
                <label class="text-xs text-gray-500 mb-1.5 block font-medium">Başlık</label>
                <input type="text" name="title" value="{{ old('title') }}"
                    class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-brand"
                    placeholder="Günün Ayeti / Günün Hadisi...">
            </div>
            <div>
                <label class="text-xs text-gray-500 mb-1.5 block font-medium">Arapça Metin</label>
                <textarea name="content_ar" rows="2" dir="rtl"
                    class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-brand resize-none"
                    placeholder="بِسْمِ اللَّهِ...">{{ old('content_ar') }}</textarea>
            </div>
            <div>
                <label class="text-xs text-gray-500 mb-1.5 block font-medium">Türkçe Metin *</label>
                <textarea name="content_tr" rows="4" required
                    class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-brand resize-none"
                    placeholder="Türkçe metin...">{{ old('content_tr') }}</textarea>
                @error('content_tr') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="text-xs text-gray-500 mb-1.5 block font-medium">Kaynak</label>
                <input type="text" name="source" value="{{ old('source') }}"
                    class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-brand"
                    placeholder="Bakara Suresi, 255. Ayet / Sahih Buhari, 1. Hadis...">
            </div>
            <div class="flex items-center gap-2">
                <input type="checkbox" name="is_published" id="is_published" value="1" checked
                    class="w-4 h-4 accent-brand">
                <label for="is_published" class="text-sm text-gray-600">Hemen yayınla</label>
            </div>
            <div class="flex gap-3 pt-2">
                <button type="submit" class="bg-brand text-white px-5 py-2 rounded-lg text-sm font-medium hover:bg-brand-light transition">
                    Kaydet
                </button>
                <a href="{{ route('admin.daily-content.index') }}" class="border border-gray-200 text-gray-600 px-5 py-2 rounded-lg text-sm hover:border-gray-300 transition">
                    İptal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
