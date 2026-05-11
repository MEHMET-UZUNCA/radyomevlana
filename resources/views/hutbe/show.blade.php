@extends('layouts.app')
@section('title', $hutbe->title)

@section('content')
<div class="bg-brand-dark py-8 px-4">
    <div class="max-w-3xl mx-auto">
        <a href="{{ route('hutbe.index') }}" class="text-white/50 hover:text-white text-sm flex items-center gap-1.5 mb-4">
            <i class="fa-solid fa-arrow-left text-xs"></i> Hutbeler
        </a>
        <h1 class="text-white font-bold text-2xl leading-snug">{{ $hutbe->title }}</h1>
        <p class="text-white/50 text-sm mt-2">{{ $hutbe->date->format('d.m.Y') }}</p>
    </div>
</div>

<div class="max-w-3xl mx-auto px-4 py-10">
    {{-- İndir butonları --}}
    @if($hutbe->pdf_url || $hutbe->word_url)
    <div class="bg-brand-pale border border-brand/20 rounded-xl p-4 mb-8 flex flex-wrap items-center gap-3">
        <div class="flex-1">
            <p class="text-brand font-semibold text-sm">Bu Hutbeyi İndir</p>
            <p class="text-brand/60 text-xs">PDF veya Word formatında bilgisayarınıza kaydedin</p>
        </div>
        <div class="flex gap-2">
            @if($hutbe->pdf_url)
            <a href="{{ route('hutbe.download', [$hutbe, 'pdf']) }}"
               class="flex items-center gap-2 bg-red-600 text-white px-4 py-2.5 rounded-xl hover:bg-red-500 transition text-sm font-medium">
                <i class="fa-solid fa-file-pdf text-lg"></i>
                <div>
                    <div class="text-xs opacity-75">İndir</div>
                    <div class="font-bold leading-none">PDF</div>
                </div>
            </a>
            @endif
            @if($hutbe->word_url)
            <a href="{{ route('hutbe.download', [$hutbe, 'word']) }}"
               class="flex items-center gap-2 bg-blue-700 text-white px-4 py-2.5 rounded-xl hover:bg-blue-600 transition text-sm font-medium">
                <i class="fa-solid fa-file-word text-lg"></i>
                <div>
                    <div class="text-xs opacity-75">İndir</div>
                    <div class="font-bold leading-none">Word</div>
                </div>
            </a>
            @endif
        </div>
    </div>
    @endif

    {{-- İçerik --}}
    @if($hutbe->content)
    <div class="prose prose-sm max-w-none text-gray-700 leading-relaxed space-y-4">
        @foreach(explode("\n\n", $hutbe->content) as $para)
            @if(trim($para))
            <p>{{ trim($para) }}</p>
            @endif
        @endforeach
    </div>
    @else
    <div class="text-center py-12 text-gray-400">
        <i class="fa-solid fa-file-lines text-5xl block mb-4 text-gray-200"></i>
        <p class="text-gray-500 font-medium mb-1">Bu hutbenin tam metni için</p>
        <p class="text-sm mb-5">
            @if($hutbe->pdf_url)
                PDF dosyasını indirerek okuyabilirsiniz.
            @elseif($hutbe->word_url)
                Word dosyasını indirerek okuyabilirsiniz.
            @else
                dosya henüz mevcut değil.
            @endif
        </p>
        <div class="flex justify-center gap-3 flex-wrap">
            @if($hutbe->pdf_url)
            <a href="{{ route('hutbe.download', [$hutbe, 'pdf']) }}"
               class="inline-flex items-center gap-2 bg-red-600 text-white px-5 py-3 rounded-xl hover:bg-red-500 transition font-medium">
                <i class="fa-solid fa-file-pdf text-lg"></i> PDF İndir
            </a>
            @endif
            @if($hutbe->word_url)
            <a href="{{ route('hutbe.download', [$hutbe, 'word']) }}"
               class="inline-flex items-center gap-2 bg-blue-700 text-white px-5 py-3 rounded-xl hover:bg-blue-600 transition font-medium">
                <i class="fa-solid fa-file-word text-lg"></i> Word İndir
            </a>
            @endif
        </div>
    </div>
    @endif
</div>
@endsection
