@extends('layouts.app')
@section('title', $announcement->title)

@section('content')
<div class="bg-brand-dark py-8 px-4">
    <div class="max-w-3xl mx-auto">
        <a href="{{ route('announcements.index') }}" class="text-white/50 hover:text-white text-sm flex items-center gap-1.5 mb-4">
            <i class="fa-solid fa-arrow-left text-xs"></i> Haberler & Duyurular
        </a>
        <div class="flex items-center gap-2 mb-2">
            <span class="text-xs font-semibold px-2 py-0.5 rounded-full bg-white/10 text-white/70">
                {{ $announcement->source === 'kktc' ? 'KKTC Din İşleri' : ($announcement->source === 'evkaf' ? 'Evkaf' : 'Editör') }}
            </span>
            @if($announcement->published_at)
            <span class="text-white/40 text-xs">{{ $announcement->published_at->format('d.m.Y') }}</span>
            @endif
        </div>
        <h1 class="text-white font-bold text-2xl leading-snug">{{ $announcement->title }}</h1>
    </div>
</div>

<div class="max-w-3xl mx-auto px-4 py-10">
    @if($announcement->content)
    <div class="prose prose-sm max-w-none text-gray-700 leading-relaxed space-y-4">
        @foreach(explode("\n\n", $announcement->content) as $para)
            @if(trim($para)) <p>{{ trim($para) }}</p> @endif
        @endforeach
    </div>
    @elseif($announcement->excerpt)
    <p class="text-gray-700 text-base leading-relaxed">{{ $announcement->excerpt }}</p>
    @endif

    @if($announcement->source_url)
    <div class="mt-8 pt-6 border-t border-gray-100">
        <a href="{{ $announcement->source_url }}" target="_blank"
           class="inline-flex items-center gap-2 text-brand hover:underline text-sm">
            <i class="fa-solid fa-arrow-up-right-from-square"></i> Orijinal kaynağa git
        </a>
    </div>
    @endif
</div>
@endsection
