@extends('layouts.admin')
@section('title', 'Sayfa Düzenle')

@section('content')
<div class="max-w-3xl">
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
        <div class="mb-4 bg-gray-50 border border-gray-200 rounded-lg px-3 py-2 text-xs text-gray-500 font-mono">
            URL: <span class="text-brand">{{ url('/sayfa/' . $page->slug) }}</span>
        </div>

        <form action="{{ route('admin.pages.update', $page) }}" method="POST" class="space-y-4">
            @csrf @method('PUT')

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="text-xs text-gray-500 mb-1.5 block font-medium">Başlık *</label>
                    <input type="text" name="title" required value="{{ old('title', $page->title) }}"
                        class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-brand">
                </div>
                <div>
                    <label class="text-xs text-gray-500 mb-1.5 block font-medium">Slug (URL)</label>
                    <input type="text" name="slug" value="{{ old('slug', $page->slug) }}"
                        class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-brand font-mono">
                </div>
            </div>

            <div>
                <label class="text-xs text-gray-500 mb-1.5 block font-medium">Kısa Özet</label>
                <textarea name="excerpt" rows="2"
                    class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-brand resize-none">{{ old('excerpt', $page->excerpt) }}</textarea>
            </div>

            <div>
                <label class="text-xs text-gray-500 mb-1.5 block font-medium">İçerik *</label>
                <textarea name="content" rows="14" required
                    class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-brand resize-none font-mono">{{ old('content', $page->content) }}</textarea>
            </div>

            <div>
                <label class="text-xs text-gray-500 mb-1.5 block font-medium">Meta Açıklama</label>
                <input type="text" name="meta_description" value="{{ old('meta_description', $page->meta_description) }}" maxlength="320"
                    class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-brand">
            </div>

            <div class="flex items-center gap-2">
                <input type="checkbox" name="is_published" id="pub" value="1"
                       {{ old('is_published', $page->is_published) ? 'checked' : '' }} class="w-4 h-4 accent-brand">
                <label for="pub" class="text-sm text-gray-600">Yayında</label>
            </div>

            <div class="flex gap-3">
                <button type="submit" class="bg-brand text-white px-5 py-2 rounded-lg text-sm font-medium hover:bg-brand-light transition">Güncelle</button>
                <a href="{{ route('admin.pages.index') }}" class="border border-gray-200 text-gray-600 px-5 py-2 rounded-lg text-sm hover:border-gray-300 transition">İptal</a>
            </div>
        </form>
    </div>
</div>
@endsection
