@extends('layouts.app')
@section('title', $page->title)
@if($page->meta_description)
@section('description', $page->meta_description)
@endif

@section('content')
<div class="bg-gradient-to-b from-brand-dark to-brand py-10 px-4">
    <div class="max-w-3xl mx-auto">
        <a href="{{ route('home') }}" class="text-white/50 hover:text-white text-sm flex items-center gap-1.5 mb-4">
            <i class="fa-solid fa-arrow-left text-xs"></i> Ana Sayfa
        </a>
        <h1 class="text-white font-bold text-2xl md:text-3xl">{{ $page->title }}</h1>
        @if($page->excerpt)
        <p class="text-white/70 mt-2 text-sm leading-relaxed">{{ $page->excerpt }}</p>
        @endif
    </div>
</div>

<div class="max-w-3xl mx-auto px-4 py-12">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
        <div class="prose prose-lg max-w-none text-gray-700 leading-loose space-y-5">
            @foreach(explode("\n\n", $page->content) as $para)
                @php $para = trim($para); @endphp
                @if($para)
                    @if(str_starts_with($para, '"') || str_starts_with($para, '"') || str_starts_with($para, '...'))
                    <blockquote class="border-l-4 border-brand pl-5 italic text-gray-600 my-6 text-lg">{{ $para }}</blockquote>
                    @else
                    <p>{{ $para }}</p>
                    @endif
                @endif
            @endforeach
        </div>
    </div>
</div>
@endsection
