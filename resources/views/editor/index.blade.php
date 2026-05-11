@extends('layouts.app')
@section('title', 'Editör')

@section('content')
{{-- Hero --}}
<div class="relative overflow-hidden py-16 px-4" style="background: linear-gradient(135deg, #1a2e1a 0%, #0f4a28 50%, #1a2e1a 100%);">
    {{-- Geometric pattern --}}
    <div class="absolute inset-0 opacity-5" style="background-image: url('data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 width=%2260%22 height=%2260%22><path d=%22M30 0 L60 30 L30 60 L0 30Z%22 fill=%22none%22 stroke=%22white%22 stroke-width=%221%22/><circle cx=%2230%22 cy=%2230%22 r=%2210%22 fill=%22none%22 stroke=%22white%22 stroke-width=%221%22/></svg>'); background-size:60px 60px;"></div>
    <div class="relative max-w-3xl mx-auto text-center">
        <div class="inline-flex items-center gap-2 bg-white/10 px-4 py-1.5 rounded-full text-gold text-sm mb-4">
            <i class="fa-solid fa-feather-pointed"></i>
            <span>Editör Köşesi</span>
        </div>
        <p class="arabic text-gold text-3xl leading-loose">الْقَلَمُ أَحَدُ اللِّسَانَيْنِ</p>
        <p class="text-white/50 text-xs mt-1 mb-4">Kalem iki dilden biridir.</p>
        <h1 class="text-white font-bold text-3xl">Söz Kapıdır…</h1>
        <p class="text-white/60 text-sm mt-2 max-w-xl mx-auto leading-relaxed">
            Zahirde bir kelime gibi görünür… fakat bâtında bir kapıdır. Burada yazılanlar, kendini arayana değil; kendini bulmaya hazır olana açılır.
        </p>
    </div>
</div>

{{-- Posts grid --}}
<div class="max-w-5xl mx-auto px-4 py-12">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($posts as $post)
        <a href="{{ route('editor.show', $post) }}" class="group block">
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm group-hover:shadow-md transition overflow-hidden h-full flex flex-col">
                {{-- Image or pattern --}}
                @if($post->image)
                <div class="h-40 overflow-hidden">
                    <img src="{{ $post->image }}" alt="{{ $post->title }}"
                         class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                </div>
                @else
                <div class="h-40 flex items-center justify-center relative overflow-hidden"
                     style="background: linear-gradient(135deg, #064e3b, #1a6b3c);">
                    <div class="absolute inset-0 opacity-10" style="background-image: url('data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 width=%2240%22 height=%2240%22><path d=%22M20 0 L40 20 L20 40 L0 20Z%22 fill=%22none%22 stroke=%22white%22 stroke-width=%221%22/></svg>');background-size:40px 40px;"></div>
                    <i class="fa-solid fa-feather-pointed text-white/30 text-5xl relative"></i>
                </div>
                @endif
                <div class="p-5 flex flex-col flex-1">
                    <p class="text-xs text-brand/60 mb-2">{{ $post->published_at?->format('d.m.Y') }}</p>
                    <h2 class="font-bold text-gray-800 text-base leading-snug mb-2 group-hover:text-brand transition line-clamp-2">
                        {{ $post->title }}
                    </h2>
                    @if($post->excerpt)
                    <p class="text-gray-500 text-sm leading-relaxed line-clamp-3 flex-1">{{ $post->excerpt }}</p>
                    @endif
                    <div class="mt-4 text-brand text-xs font-medium flex items-center gap-1">
                        Devamını Oku <i class="fa-solid fa-arrow-right text-xs"></i>
                    </div>
                </div>
            </div>
        </a>
        @empty
        <div class="col-span-3 text-center py-16 text-gray-400">
            <i class="fa-solid fa-feather-pointed text-5xl block mb-3 text-gray-200"></i>
            Henüz yazı yok.
        </div>
        @endforelse
    </div>
    @if($posts->hasPages())
    <div class="mt-8">{{ $posts->links() }}</div>
    @endif
</div>
@endsection
