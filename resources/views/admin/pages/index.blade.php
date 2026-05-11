@extends('layouts.admin')
@section('title', 'Sayfalar')

@section('content')
<div class="flex justify-end mb-5">
    <a href="{{ route('admin.pages.create') }}"
       class="text-xs bg-brand text-white px-4 py-2 rounded-lg hover:bg-brand-light transition flex items-center gap-1.5">
        <i class="fa-solid fa-plus"></i> Yeni Sayfa
    </a>
</div>

<div class="space-y-3">
    @forelse($pages as $page)
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-5 flex items-center gap-4">
        <div class="flex-1 min-w-0">
            <div class="flex items-center gap-2 mb-0.5">
                <span class="font-semibold text-gray-800">{{ $page->title }}</span>
                @if(!$page->is_published)
                <span class="text-xs bg-red-50 text-red-500 px-1.5 py-0.5 rounded flex items-center gap-1">
                    <i class="fa-solid fa-eye-slash"></i> Gizli
                </span>
                @endif
            </div>
            <div class="text-xs text-gray-400 font-mono">
                URL: <span class="text-brand">/sayfa/{{ $page->slug }}</span>
            </div>
            @if($page->excerpt)
            <p class="text-gray-500 text-xs mt-1 line-clamp-1">{{ $page->excerpt }}</p>
            @endif
        </div>
        <div class="flex gap-1 shrink-0">
            <a href="{{ route('page.show', $page->slug) }}" target="_blank"
               class="text-xs px-2 py-1 rounded border border-gray-200 hover:border-brand hover:text-brand transition">
                <i class="fa-solid fa-arrow-up-right-from-square text-xs"></i>
            </a>
            <a href="{{ route('admin.pages.edit', $page) }}"
               class="text-xs px-2 py-1 rounded border border-gray-200 hover:border-brand hover:text-brand transition">Düzenle</a>
            <form action="{{ route('admin.pages.destroy', $page) }}" method="POST" onsubmit="return confirm('Bu sayfa silinsin mi?')">
                @csrf @method('DELETE')
                <button class="text-xs px-2 py-1 rounded border border-red-200 text-red-500 hover:bg-red-50 transition">Sil</button>
            </form>
        </div>
    </div>
    @empty
    <div class="bg-white rounded-xl border border-gray-200 p-8 text-center text-gray-400">
        <i class="fa-solid fa-file-lines text-4xl mb-2 block text-gray-200"></i>
        Henüz sayfa oluşturulmadı.
    </div>
    @endforelse
</div>

<div class="mt-4 bg-blue-50 border border-blue-200 rounded-lg p-4 text-sm text-blue-700">
    <i class="fa-solid fa-circle-info mr-2"></i>
    Sayfa oluşturduktan sonra <strong>Menü Yönetimi</strong>'ne giderek URL alanına
    <code class="bg-blue-100 px-1 rounded">/sayfa/[slug]</code> girerek menüye ekleyebilirsiniz.
</div>
@endsection
