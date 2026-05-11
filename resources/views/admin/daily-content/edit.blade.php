@extends('layouts.admin')
@section('title', 'İçerik Düzenle')

@section('content')
<div class="max-w-2xl">
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
        <form action="{{ route('admin.daily-content.update', $dailyContent) }}" method="POST" class="space-y-4">
            @csrf @method('PUT')
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="text-xs text-gray-500 mb-1.5 block font-medium">Tür</label>
                    <input type="text" value="{{ ['ayet'=>'Ayet','hadis'=>'Hadis','soz'=>'Söz'][$dailyContent->type] }}"
                        disabled class="w-full border border-gray-100 bg-gray-50 rounded-lg px-3 py-2 text-sm text-gray-400">
                </div>
                <div>
                    <label class="text-xs text-gray-500 mb-1.5 block font-medium">Tarih *</label>
                    <input type="date" name="date" required value="{{ old('date', $dailyContent->date->toDateString()) }}"
                        class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-brand">
                </div>
            </div>
            <div>
                <label class="text-xs text-gray-500 mb-1.5 block font-medium">Başlık</label>
                <input type="text" name="title" value="{{ old('title', $dailyContent->title) }}"
                    class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-brand">
            </div>
            <div>
                <label class="text-xs text-gray-500 mb-1.5 block font-medium">Arapça Metin</label>
                <textarea name="content_ar" rows="2" dir="rtl"
                    class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-brand resize-none">{{ old('content_ar', $dailyContent->content_ar) }}</textarea>
            </div>
            <div>
                <label class="text-xs text-gray-500 mb-1.5 block font-medium">Türkçe Metin *</label>
                <textarea name="content_tr" rows="4" required
                    class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-brand resize-none">{{ old('content_tr', $dailyContent->content_tr) }}</textarea>
            </div>
            <div>
                <label class="text-xs text-gray-500 mb-1.5 block font-medium">Kaynak</label>
                <input type="text" name="source" value="{{ old('source', $dailyContent->source) }}"
                    class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-brand">
            </div>
            <div class="flex items-center gap-2">
                <input type="checkbox" name="is_published" id="is_published" value="1"
                    {{ $dailyContent->is_published ? 'checked' : '' }}
                    class="w-4 h-4 accent-brand">
                <label for="is_published" class="text-sm text-gray-600">Yayında</label>
            </div>
            <div class="flex gap-3 pt-2">
                <button type="submit" class="bg-brand text-white px-5 py-2 rounded-lg text-sm font-medium hover:bg-brand-light transition">
                    Güncelle
                </button>
                <a href="{{ route('admin.daily-content.index') }}" class="border border-gray-200 text-gray-600 px-5 py-2 rounded-lg text-sm hover:border-gray-300 transition">
                    İptal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
