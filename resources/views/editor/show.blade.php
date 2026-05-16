@extends('layouts.app')
@section('title', $editorPost->title)

@section('content')
{{-- Header --}}
<div class="relative overflow-hidden py-12 px-4" style="background: linear-gradient(135deg, #0f4a28 0%, #1a6b3c 100%);">
    <div class="absolute inset-0 opacity-5" style="background-image: url('data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 width=%2260%22 height=%2260%22><path d=%22M30 0 L60 30 L30 60 L0 30Z%22 fill=%22none%22 stroke=%22white%22 stroke-width=%221%22/></svg>');background-size:60px 60px;"></div>
    <div class="relative max-w-3xl mx-auto">
        <a href="{{ route('editor.index') }}" class="text-white/50 hover:text-white text-sm flex items-center gap-1.5 mb-5">
            <i class="fa-solid fa-arrow-left text-xs"></i> Editör Köşesi
        </a>
        @if($editorPost->image)
        <div class="w-20 h-20 rounded-2xl overflow-hidden mb-4 border-2 border-white/20">
            <img src="{{ $editorPost->image }}" alt="" class="w-full h-full object-cover">
        </div>
        @else
        <div class="w-14 h-14 rounded-2xl bg-white/10 flex items-center justify-center mb-4 border border-white/20">
            <i class="fa-solid fa-feather-pointed text-gold text-2xl"></i>
        </div>
        @endif
        <h1 class="text-white font-bold text-2xl md:text-3xl leading-snug max-w-2xl">{{ $editorPost->title }}</h1>
        <p class="text-white/40 text-sm mt-3">{{ $editorPost->published_at?->format('d.m.Y') }}</p>
    </div>
</div>

{{-- Content --}}
<div class="max-w-3xl mx-auto px-4 py-12">
    @if($editorPost->image)
    <div class="rounded-2xl overflow-hidden mb-8 shadow-md">
        <img src="{{ $editorPost->image }}" alt="{{ $editorPost->title }}" class="w-full object-cover max-h-80">
    </div>
    @endif

    <div class="prose prose-lg max-w-none text-gray-700 leading-loose space-y-5
                [&_h3]:text-brand [&_h3]:font-bold [&_h3]:text-xl [&_h3]:mt-8 [&_h3]:mb-3
                [&_blockquote]:border-l-4 [&_blockquote]:border-brand [&_blockquote]:pl-5 [&_blockquote]:italic [&_blockquote]:text-gray-600 [&_blockquote]:my-6
                [&_ul]:list-disc [&_ul]:pl-6 [&_ul]:space-y-1
                [&_li]:text-gray-700 [&_strong]:text-gray-800">
        {!! $editorPost->content !!}
    </div>

    <div class="mt-10 pt-6 border-t border-gray-100 flex items-center gap-3">
        <div class="w-10 h-10 rounded-full bg-brand flex items-center justify-center shrink-0">
            <i class="fa-solid fa-feather-pointed text-white text-sm"></i>
        </div>
        <div>
            <p class="font-semibold text-gray-700 text-sm">Editör — M.U.</p>
            <p class="text-gray-400 text-xs">www.radyomevlana.com</p>
        </div>
    </div>
</div>
@endsection
