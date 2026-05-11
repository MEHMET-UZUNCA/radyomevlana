@extends('layouts.admin')
@section('title', 'Duyurular & Haberler')

@section('content')
<div class="flex items-center gap-2 mb-5 flex-wrap">
    <div class="flex gap-2">
        @foreach(['all'=>'Tümü','kktc'=>'KKTC','evkaf'=>'Evkaf','manual'=>'Manuel'] as $val=>$label)
        <a href="{{ route('admin.announcements.index', ['source'=>$val]) }}"
           class="px-3 py-1.5 rounded-lg text-sm font-medium transition {{ $source===$val?'bg-brand text-white':'bg-white text-gray-600 border border-gray-200 hover:border-brand' }}">
            {{ $label }}
        </a>
        @endforeach
    </div>
    <div class="ml-auto flex gap-2 flex-wrap">
        <form action="{{ route('admin.announcements.scrape-kktc') }}" method="POST">
            @csrf
            <button class="text-xs bg-green-700 text-white px-3 py-1.5 rounded-lg hover:bg-green-600 transition flex items-center gap-1.5">
                <i class="fa-solid fa-rotate"></i> KKTC Çek
            </button>
        </form>
        <form action="{{ route('admin.announcements.scrape-evkaf') }}" method="POST">
            @csrf
            <button class="text-xs bg-amber-600 text-white px-3 py-1.5 rounded-lg hover:bg-amber-500 transition flex items-center gap-1.5">
                <i class="fa-solid fa-rotate"></i> Evkaf Çek
            </button>
        </form>
        <a href="{{ route('admin.announcements.create') }}"
           class="text-xs bg-brand text-white px-3 py-1.5 rounded-lg hover:bg-brand-light transition flex items-center gap-1.5">
            <i class="fa-solid fa-plus"></i> Manuel Ekle
        </a>
    </div>
</div>

<div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 border-b border-gray-200">
            <tr>
                <th class="text-left px-4 py-3 text-gray-500 font-medium">Başlık</th>
                <th class="text-left px-4 py-3 text-gray-500 font-medium">Kategori</th>
                <th class="text-left px-4 py-3 text-gray-500 font-medium">Kaynak</th>
                <th class="text-left px-4 py-3 text-gray-500 font-medium">Tarih</th>
                <th class="px-4 py-3"></th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-50">
            @forelse($announcements as $ann)
            <tr class="hover:bg-gray-50">
                <td class="px-4 py-3 max-w-xs">
                    <div class="font-medium text-gray-800 truncate">{{ $ann->title }}</div>
                    @if($ann->excerpt)<div class="text-xs text-gray-400 truncate mt-0.5">{{ Str::limit($ann->excerpt, 60) }}</div>@endif
                </td>
                <td class="px-4 py-3">
                    <span class="text-xs px-2 py-0.5 rounded-full
                        {{ $ann->category==='baskan'?'bg-purple-100 text-purple-700':($ann->category==='yazi'?'bg-blue-100 text-blue-700':'bg-gray-100 text-gray-600') }}">
                        {{ ['baskan'=>'Başkandan','yazi'=>'Yazılar','duyuru'=>'Duyurular'][$ann->category] }}
                    </span>
                </td>
                <td class="px-4 py-3 text-xs">
                    <span class="{{ $ann->source==='kktc'?'text-green-700':($ann->source==='evkaf'?'text-amber-600':'text-gray-500') }}">
                        {{ strtoupper($ann->source) }}
                    </span>
                    @if(!$ann->is_published)<span class="text-red-400 ml-1"><i class="fa-solid fa-eye-slash"></i></span>@endif
                </td>
                <td class="px-4 py-3 text-gray-400 text-xs whitespace-nowrap">{{ $ann->published_at?->format('d.m.Y') ?? '–' }}</td>
                <td class="px-4 py-3">
                    <div class="flex gap-1">
                        <a href="{{ route('admin.announcements.edit', $ann) }}"
                           class="text-xs px-2 py-1 rounded border border-gray-200 hover:border-brand hover:text-brand transition">Düzenle</a>
                        <form action="{{ route('admin.announcements.destroy', $ann) }}" method="POST" onsubmit="return confirm('Silinsin mi?')">
                            @csrf @method('DELETE')
                            <button class="text-xs px-2 py-1 rounded border border-red-200 text-red-500 hover:bg-red-50 transition">Sil</button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="5" class="px-4 py-8 text-center text-gray-400">Kayıt yok.</td></tr>
            @endforelse
        </tbody>
    </table>
    @if($announcements->hasPages())
    <div class="px-4 py-3 border-t border-gray-100">{{ $announcements->appends(['source'=>$source])->links() }}</div>
    @endif
</div>
@endsection
