@extends('layouts.admin')
@section('title', 'Dashboard')

@section('content')
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    @foreach([
        ['Dinleyici', $stats['listeners'], 'fa-headphones', 'bg-brand text-white'],
        ['Bekleyen İstek', $pending, 'fa-music', 'bg-amber-500 text-white'],
        ['Toplam İstek', $total_requests, 'fa-list', 'bg-gray-700 text-white'],
        ['Çalınan Parça', $total_songs, 'fa-clock-rotate-left', 'bg-blue-600 text-white'],
    ] as [$label, $value, $icon, $color])
    <div class="bg-white rounded-xl p-4 border border-gray-200 shadow-sm flex items-center gap-4">
        <div class="w-10 h-10 {{ $color }} rounded-xl flex items-center justify-center shrink-0">
            <i class="fa-solid {{ $icon }} text-sm"></i>
        </div>
        <div>
            <div class="text-2xl font-bold text-gray-800">{{ $value }}</div>
            <div class="text-xs text-gray-400">{{ $label }}</div>
        </div>
    </div>
    @endforeach
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-5">

    {{-- Yayın Durumu --}}
    <div class="bg-white rounded-xl p-5 border border-gray-200 shadow-sm">
        <h3 class="font-semibold text-gray-700 mb-4 flex items-center gap-2">
            <i class="fa-solid fa-radio text-brand text-sm"></i> Yayın Durumu
        </h3>
        <div class="flex items-center gap-3 mb-3">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold {{ $stats['online'] ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                <span class="w-1.5 h-1.5 rounded-full {{ $stats['online'] ? 'bg-green-500 animate-pulse' : 'bg-red-500' }}"></span>
                {{ $stats['online'] ? 'CANLI' : 'ÇEVRIMDIŞI' }}
            </span>
            <span class="text-gray-500 text-sm">{{ $stats['bitrate'] }} kbps</span>
        </div>
        <div class="bg-gray-50 rounded-lg p-3">
            <p class="text-xs text-gray-400 mb-0.5">Şu An Çalıyor</p>
            <p class="font-medium text-gray-800 text-sm">{{ $stats['current_song'] }}</p>
        </div>
        <div class="mt-3 grid grid-cols-2 gap-2 text-sm">
            <div class="bg-gray-50 rounded-lg p-2.5 text-center">
                <div class="font-bold text-gray-800">{{ $stats['listeners'] }}</div>
                <div class="text-xs text-gray-400">Anlık</div>
            </div>
            <div class="bg-gray-50 rounded-lg p-2.5 text-center">
                <div class="font-bold text-gray-800">{{ $stats['peak_listeners'] }}</div>
                <div class="text-xs text-gray-400">Zirve</div>
            </div>
        </div>
    </div>

    {{-- Son Çalanlar --}}
    <div class="bg-white rounded-xl p-5 border border-gray-200 shadow-sm">
        <h3 class="font-semibold text-gray-700 mb-4 flex items-center gap-2">
            <i class="fa-solid fa-clock-rotate-left text-brand text-sm"></i> Son Çalanlar
        </h3>
        <div class="space-y-2">
            @forelse($recent_history as $s)
            <div class="flex items-center gap-3 py-1.5 border-b border-gray-50 last:border-0">
                @if($s->album_art)
                <img src="{{ $s->album_art }}" alt="" class="w-8 h-8 rounded-lg object-cover shrink-0">
                @else
                <div class="w-8 h-8 rounded-lg bg-gray-100 flex items-center justify-center shrink-0">
                    <i class="fa-solid fa-music text-gray-300 text-xs"></i>
                </div>
                @endif
                <div class="flex-1 min-w-0">
                    <div class="text-sm font-medium text-gray-800 truncate">{{ $s->title }}</div>
                    @if($s->artist)<div class="text-xs text-gray-400 truncate">{{ $s->artist }}</div>@endif
                </div>
                <span class="text-xs text-gray-300 shrink-0">{{ $s->played_at->diffForHumans() }}</span>
            </div>
            @empty
            <p class="text-gray-400 text-sm text-center py-4">Kayıt yok.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
