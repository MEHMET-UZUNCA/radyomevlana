@extends('layouts.app')
@section('title', 'Hutbeler')

@section('content')
<div class="bg-gradient-to-b from-brand-dark to-brand py-10 px-4">
    <div class="max-w-5xl mx-auto text-center">
        <p class="arabic text-gold text-2xl leading-loose">خَيْرُكُمْ مَنْ تَعَلَّمَ الْقُرْآنَ وَعَلَّمَهُ</p>
        <h1 class="text-white font-bold text-3xl mt-2">Hutbeler</h1>
        <p class="text-white/60 text-sm mt-1">KKTC Din İşleri Başkanlığı Hutbe Arşivi</p>
    </div>
</div>

<div class="max-w-5xl mx-auto px-4 py-10">
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
        @forelse($hutbes as $hutbe)
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm hover:shadow-md transition overflow-hidden flex flex-col">
            <div class="bg-brand-pale px-5 py-4 border-b border-brand/10">
                <p class="text-xs text-brand/60 mb-1">{{ $hutbe->date->format('d.m.Y') }}</p>
                <h2 class="font-semibold text-gray-800 text-sm leading-snug line-clamp-2">{{ $hutbe->title }}</h2>
            </div>
            <div class="px-5 py-3 flex items-center gap-2 mt-auto">
                <a href="{{ route('hutbe.show', $hutbe) }}"
                   class="flex-1 text-center text-xs bg-brand text-white px-3 py-2 rounded-lg hover:bg-brand-light transition">
                    <i class="fa-solid fa-eye mr-1"></i> Oku
                </a>
                @if($hutbe->pdf_url)
                <a href="{{ route('hutbe.download', [$hutbe, 'pdf']) }}"
                   class="text-xs bg-red-50 text-red-600 border border-red-200 px-3 py-2 rounded-lg hover:bg-red-100 transition whitespace-nowrap">
                    <i class="fa-solid fa-file-pdf"></i> PDF
                </a>
                @endif
                @if($hutbe->word_url)
                <a href="{{ route('hutbe.download', [$hutbe, 'word']) }}"
                   class="text-xs bg-blue-50 text-blue-600 border border-blue-200 px-3 py-2 rounded-lg hover:bg-blue-100 transition whitespace-nowrap">
                    <i class="fa-solid fa-file-word"></i> Word
                </a>
                @endif
            </div>
        </div>
        @empty
        <div class="col-span-3 text-center py-16 text-gray-400">
            <i class="fa-solid fa-scroll text-5xl block mb-3 text-gray-200"></i>
            Henüz hutbe yüklenmedi.
        </div>
        @endforelse
    </div>

    @if($hutbes->hasPages())
    <div class="mt-8">{{ $hutbes->links() }}</div>
    @endif
</div>
@endsection
