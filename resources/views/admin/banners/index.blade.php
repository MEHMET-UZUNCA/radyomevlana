@extends('layouts.admin')
@section('title', 'Bannerlar')

@section('content')
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-xl font-bold text-gray-800">Reklam Bannerları</h1>
        <p class="text-sm text-gray-500 mt-0.5">Site genelinde görüntülenen banner alanlarını yönetin</p>
    </div>
    <a href="{{ route('admin.banners.create') }}"
       class="flex items-center gap-2 bg-brand text-white px-4 py-2 rounded-xl hover:bg-brand-light transition text-sm font-medium">
        <i class="fa-solid fa-plus"></i> Yeni Banner
    </a>
</div>

@if(session('success'))
<div class="mb-4 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl text-sm">
    {{ session('success') }}
</div>
@endif

@php
$grouped = $banners->groupBy('location');
$locations = \App\Models\Banner::locations();
@endphp

@if($banners->isEmpty())
<div class="text-center py-16 text-gray-400">
    <i class="fa-solid fa-rectangle-ad text-5xl block mb-3 text-gray-200"></i>
    Henüz banner eklenmedi.
</div>
@else
<div class="space-y-6">
    @foreach($locations as $key => $label)
        @if($grouped->has($key))
        <div class="bg-white rounded-xl border border-gray-100 overflow-hidden">
            <div class="px-5 py-3 bg-gray-50 border-b border-gray-100">
                <h2 class="font-semibold text-gray-700 text-sm flex items-center gap-2">
                    <i class="fa-solid fa-location-dot text-brand text-xs"></i>
                    {{ $label }}
                </h2>
            </div>
            <div class="divide-y divide-gray-50">
                @foreach($grouped[$key] as $banner)
                <div class="px-5 py-4 flex items-center gap-4">
                    {{-- Önizleme --}}
                    <div class="w-24 h-14 rounded-lg overflow-hidden bg-gray-100 shrink-0">
                        <img src="{{ $banner->image_url }}" alt="{{ $banner->alt_text }}"
                             class="w-full h-full object-cover" loading="lazy"
                             onerror="this.parentElement.innerHTML='<div class=\'flex items-center justify-center h-full text-gray-300 text-xs\'>Yüklenemedi</div>'">
                    </div>

                    {{-- Bilgi --}}
                    <div class="flex-1 min-w-0">
                        <div class="font-medium text-gray-800 text-sm truncate">{{ $banner->name }}</div>
                        @if($banner->link_url)
                        <div class="text-xs text-gray-400 truncate mt-0.5">{{ $banner->link_url }}</div>
                        @endif
                        <div class="flex items-center gap-2 mt-1">
                            @if($banner->is_active)
                            <span class="text-xs bg-green-100 text-green-700 px-2 py-0.5 rounded-full">Aktif</span>
                            @else
                            <span class="text-xs bg-gray-100 text-gray-500 px-2 py-0.5 rounded-full">Pasif</span>
                            @endif
                            @if($banner->starts_at || $banner->ends_at)
                            <span class="text-xs text-gray-400">
                                {{ $banner->starts_at?->format('d.m.Y') ?? '∞' }} – {{ $banner->ends_at?->format('d.m.Y') ?? '∞' }}
                            </span>
                            @endif
                        </div>
                    </div>

                    {{-- Sıra --}}
                    <div class="text-xs text-gray-400 shrink-0">#{{ $banner->sort_order }}</div>

                    {{-- İşlemler --}}
                    <div class="flex items-center gap-2 shrink-0">
                        <a href="{{ route('admin.banners.edit', $banner) }}"
                           class="text-xs bg-gray-100 hover:bg-brand-pale text-gray-600 hover:text-brand px-3 py-1.5 rounded-lg transition">
                            <i class="fa-solid fa-pen-to-square"></i> Düzenle
                        </a>
                        <form action="{{ route('admin.banners.destroy', $banner) }}" method="POST"
                              onsubmit="return confirm('Bu bannerı silmek istediğinizden emin misiniz?')">
                            @csrf @method('DELETE')
                            <button class="text-xs bg-red-50 hover:bg-red-100 text-red-500 px-3 py-1.5 rounded-lg transition">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    @endforeach
</div>
@endif
@endsection
