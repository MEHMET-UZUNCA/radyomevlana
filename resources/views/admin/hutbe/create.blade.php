@extends('layouts.admin')
@section('title', 'Hutbe Ekle')

@section('content')
<div class="max-w-2xl">
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
        <form action="{{ route('admin.hutbe.store') }}" method="POST" class="space-y-4">
            @csrf
            <div class="grid grid-cols-2 gap-4">
                <div class="col-span-2">
                    <label class="text-xs text-gray-500 mb-1.5 block font-medium">Başlık *</label>
                    <input type="text" name="title" required value="{{ old('title') }}"
                        class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-brand">
                </div>
                <div>
                    <label class="text-xs text-gray-500 mb-1.5 block font-medium">Tarih *</label>
                    <input type="date" name="date" required value="{{ old('date', today()->toDateString()) }}"
                        class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-brand">
                </div>
            </div>
            <div>
                <label class="text-xs text-gray-500 mb-1.5 block font-medium">PDF URL</label>
                <input type="url" name="pdf_url" value="{{ old('pdf_url') }}"
                    class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-brand"
                    placeholder="https://...">
            </div>
            <div>
                <label class="text-xs text-gray-500 mb-1.5 block font-medium">Word URL</label>
                <input type="url" name="word_url" value="{{ old('word_url') }}"
                    class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-brand"
                    placeholder="https://...">
            </div>
            <div>
                <label class="text-xs text-gray-500 mb-1.5 block font-medium">İçerik</label>
                <textarea name="content" rows="8"
                    class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-brand resize-none font-mono"
                    placeholder="Hutbe metni...">{{ old('content') }}</textarea>
            </div>
            <div class="flex gap-3">
                <button type="submit" class="bg-brand text-white px-5 py-2 rounded-lg text-sm font-medium hover:bg-brand-light transition">Kaydet</button>
                <a href="{{ route('admin.hutbe.index') }}" class="border border-gray-200 text-gray-600 px-5 py-2 rounded-lg text-sm hover:border-gray-300 transition">İptal</a>
            </div>
        </form>
    </div>
</div>
@endsection
