@extends('layouts.admin')
@section('title', 'Editör Yazıları')

@section('content')
<div class="flex justify-end mb-5">
    <a href="{{ route('admin.editor.create') }}"
       class="text-xs bg-brand text-white px-4 py-2 rounded-lg hover:bg-brand-light transition flex items-center gap-1.5">
        <i class="fa-solid fa-plus"></i> Yeni Yazı Ekle
    </a>
</div>

<div class="space-y-3">
    @forelse($posts as $post)
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-5 flex gap-4">
        @if($post->image)
        <img src="{{ $post->image }}" alt="" class="w-16 h-16 rounded-xl object-cover shrink-0">
        @else
        <div class="w-16 h-16 rounded-xl bg-gradient-to-br from-brand to-brand-dark flex items-center justify-center shrink-0">
            <i class="fa-solid fa-feather-pointed text-white text-xl"></i>
        </div>
        @endif
        <div class="flex-1 min-w-0">
            <div class="flex items-start justify-between gap-3">
                <div>
                    <h3 class="font-semibold text-gray-800 leading-snug">{{ $post->title }}</h3>
                    @if($post->excerpt)
                    <p class="text-gray-400 text-sm mt-1 line-clamp-2">{{ $post->excerpt }}</p>
                    @endif
                    <p class="text-xs text-gray-300 mt-2">{{ $post->published_at?->format('d.m.Y') }}</p>
                </div>
                <div class="flex gap-1 shrink-0">
                    @if(!$post->is_published)
                    <span class="text-xs text-red-400 flex items-center gap-1 mr-2"><i class="fa-solid fa-eye-slash"></i> Gizli</span>
                    @endif
                    <a href="{{ route('admin.editor.edit', $post) }}"
                       class="text-xs px-2 py-1 rounded border border-gray-200 hover:border-brand hover:text-brand transition">Düzenle</a>
                    <form action="{{ route('admin.editor.destroy', $post) }}" method="POST" onsubmit="return confirm('Silinsin mi?')">
                        @csrf @method('DELETE')
                        <button class="text-xs px-2 py-1 rounded border border-red-200 text-red-500 hover:bg-red-50 transition">Sil</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @empty
    <div class="bg-white rounded-xl border border-gray-200 p-8 text-center text-gray-400">
        <i class="fa-solid fa-feather-pointed text-4xl mb-2 block text-gray-200"></i>
        Henüz yazı yok.
    </div>
    @endforelse
</div>
@if($posts->hasPages())
<div class="mt-4">{{ $posts->links() }}</div>
@endif
@endsection
