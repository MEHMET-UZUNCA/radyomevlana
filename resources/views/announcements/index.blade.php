@extends('layouts.app')
@section('title', 'Haberler & Duyurular')

@section('content')
<div class="bg-gradient-to-b from-brand-dark to-brand py-10 px-4">
    <div class="max-w-5xl mx-auto text-center">
        <h1 class="text-white font-bold text-3xl">Haberler & Duyurular</h1>
        <p class="text-white/60 text-sm mt-1">KKTC Din İşleri Başkanlığı ve Evkaf'tan güncel haberler</p>
    </div>
</div>

<div class="max-w-5xl mx-auto px-4 py-8">
    {{-- Kaynak filtresi --}}
    <div class="flex gap-2 mb-6 flex-wrap">
        @foreach(['all'=>'Tümü','kktc'=>'KKTC Din İşleri','evkaf'=>'Evkaf','manual'=>'Editör'] as $val => $label)
        <a href="{{ route('announcements.index', ['source'=>$val]) }}"
           class="px-4 py-2 rounded-xl text-sm font-medium transition
                  {{ $source === $val ? 'bg-brand text-white shadow' : 'bg-white text-gray-600 border border-gray-200 hover:border-brand' }}">
            {{ $label }}
        </a>
        @endforeach
    </div>

    <div class="space-y-4">
        @forelse($announcements as $ann)
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm hover:shadow-md transition p-5 flex gap-4">
            <div class="w-2 rounded-full shrink-0 mt-1 {{ $ann->source === 'kktc' ? 'bg-brand' : ($ann->source === 'evkaf' ? 'bg-gold' : 'bg-gray-400') }}"></div>
            <div class="flex-1 min-w-0">
                <div class="flex items-center gap-2 mb-1 flex-wrap">
                    <span class="text-xs font-semibold px-2 py-0.5 rounded-full
                        {{ $ann->source === 'kktc' ? 'bg-brand/10 text-brand' : ($ann->source === 'evkaf' ? 'bg-gold/10 text-gold' : 'bg-gray-100 text-gray-500') }}">
                        {{ $ann->source === 'kktc' ? 'KKTC Din İşleri' : ($ann->source === 'evkaf' ? 'Evkaf' : 'Editör') }}
                    </span>
                    @if($ann->published_at)
                    <span class="text-xs text-gray-400">{{ $ann->published_at->format('d.m.Y') }}</span>
                    @endif
                </div>
                <h3 class="font-semibold text-gray-800 leading-snug">{{ $ann->title }}</h3>
                @if($ann->excerpt)
                <p class="text-gray-500 text-sm mt-1 line-clamp-2">{{ $ann->excerpt }}</p>
                @endif
                <div class="mt-3 flex gap-3">
                    @if($ann->content || $ann->excerpt)
                    <a href="{{ route('announcements.show', $ann) }}"
                       class="text-xs text-brand hover:underline flex items-center gap-1">
                        Devamını Oku <i class="fa-solid fa-arrow-right text-xs"></i>
                    </a>
                    @endif
                    @if($ann->source_url)
                    <a href="{{ $ann->source_url }}" target="_blank"
                       class="text-xs text-gray-400 hover:text-gray-600 flex items-center gap-1">
                        <i class="fa-solid fa-arrow-up-right-from-square text-xs"></i> Kaynak
                    </a>
                    @endif
                </div>
            </div>
        </div>
        @empty
        <div class="text-center py-16 text-gray-400">
            <i class="fa-solid fa-newspaper text-5xl block mb-3 text-gray-200"></i>
            Henüz içerik yok.
        </div>
        @endforelse
    </div>

    @if($announcements->hasPages())
    <div class="mt-8">{{ $announcements->appends(['source'=>$source])->links() }}</div>
    @endif
</div>
@endsection
