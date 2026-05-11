@extends('layouts.admin')
@section('title', 'Hutbe Düzenle')

@section('content')
<div class="max-w-2xl">
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
        <form action="{{ route('admin.hutbe.update', $hutbe) }}" method="POST" class="space-y-4">
            @csrf @method('PUT')
            <div>
                <label class="text-xs text-gray-500 mb-1.5 block font-medium">Başlık</label>
                <input type="text" name="title" value="{{ old('title', $hutbe->title) }}"
                    class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-brand">
            </div>
            <div>
                <label class="text-xs text-gray-500 mb-1.5 block font-medium">Tarih</label>
                <input type="date" name="date" value="{{ old('date', $hutbe->date->toDateString()) }}"
                    class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-brand">
            </div>
            <div>
                <label class="text-xs text-gray-500 mb-1.5 block font-medium">PDF URL</label>
                <input type="url" name="pdf_url" value="{{ old('pdf_url', $hutbe->pdf_url) }}"
                    class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-brand">
            </div>
            <div>
                <label class="text-xs text-gray-500 mb-1.5 block font-medium">Word URL</label>
                <input type="url" name="word_url" value="{{ old('word_url', $hutbe->word_url) }}"
                    class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-brand">
            </div>
            <div>
                <label class="text-xs text-gray-500 mb-1.5 block font-medium">İçerik</label>
                <textarea name="content" rows="8"
                    class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-brand resize-none font-mono">{{ old('content', $hutbe->content) }}</textarea>
            </div>
            <div class="flex items-center gap-2">
                <input type="checkbox" name="is_published" id="pub" value="1" {{ $hutbe->is_published ? 'checked' : '' }} class="w-4 h-4 accent-brand">
                <label for="pub" class="text-sm text-gray-600">Yayında</label>
            </div>
            <div class="flex gap-3">
                <button type="submit" class="bg-brand text-white px-5 py-2 rounded-lg text-sm font-medium hover:bg-brand-light transition">Güncelle</button>
                <a href="{{ route('admin.hutbe.index') }}" class="border border-gray-200 text-gray-600 px-5 py-2 rounded-lg text-sm hover:border-gray-300 transition">İptal</a>
            </div>
        </form>
    </div>
</div>
@endsection
