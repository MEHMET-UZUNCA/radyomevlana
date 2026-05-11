@extends('layouts.admin')
@section('title', 'Duyuru Düzenle')

@section('content')
<div class="max-w-2xl">
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
        <form action="{{ route('admin.announcements.update', $announcement) }}" method="POST" class="space-y-4">
            @csrf @method('PUT')
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="text-xs text-gray-500 mb-1.5 block font-medium">Kategori</label>
                    <select name="category" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-brand">
                        @foreach(['duyuru'=>'Duyurular','baskan'=>'Başkandan','yazi'=>'Yazılar'] as $v=>$l)
                        <option value="{{ $v }}" {{ $announcement->category===$v?'selected':'' }}>{{ $l }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="text-xs text-gray-500 mb-1.5 block font-medium">Tarih</label>
                    <input type="date" name="published_at" value="{{ old('published_at', $announcement->published_at?->toDateString()) }}"
                        class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-brand">
                </div>
            </div>
            <div>
                <label class="text-xs text-gray-500 mb-1.5 block font-medium">Başlık</label>
                <input type="text" name="title" value="{{ old('title', $announcement->title) }}"
                    class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-brand">
            </div>
            <div>
                <label class="text-xs text-gray-500 mb-1.5 block font-medium">Özet</label>
                <textarea name="excerpt" rows="2"
                    class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-brand resize-none">{{ old('excerpt', $announcement->excerpt) }}</textarea>
            </div>
            <div>
                <label class="text-xs text-gray-500 mb-1.5 block font-medium">İçerik</label>
                <textarea name="content" rows="8"
                    class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-brand resize-none">{{ old('content', $announcement->content) }}</textarea>
            </div>
            <div class="flex items-center gap-2">
                <input type="checkbox" name="is_published" id="pub" value="1"
                    {{ $announcement->is_published?'checked':'' }} class="w-4 h-4 accent-brand">
                <label for="pub" class="text-sm text-gray-600">Yayında</label>
            </div>
            <div class="flex gap-3">
                <button type="submit" class="bg-brand text-white px-5 py-2 rounded-lg text-sm font-medium hover:bg-brand-light transition">Güncelle</button>
                <a href="{{ route('admin.announcements.index') }}" class="border border-gray-200 text-gray-600 px-5 py-2 rounded-lg text-sm hover:border-gray-300 transition">İptal</a>
            </div>
        </form>
    </div>
</div>
@endsection
