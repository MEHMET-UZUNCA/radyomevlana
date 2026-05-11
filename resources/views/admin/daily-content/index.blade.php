@extends('layouts.admin')
@section('title', 'Günlük İçerik')

@section('content')
<div class="flex items-center gap-3 mb-5 flex-wrap">
    <div class="flex gap-2">
        @foreach(['all'=>'Tümü','ayet'=>'Ayet','hadis'=>'Hadis','soz'=>'Söz'] as $val => $label)
        <a href="{{ route('admin.daily-content.index', ['type'=>$val]) }}"
           class="px-3 py-1.5 rounded-lg text-sm font-medium transition
                  {{ $type === $val ? 'bg-brand text-white' : 'bg-white text-gray-600 border border-gray-200 hover:border-brand' }}">
            {{ $label }}
        </a>
        @endforeach
    </div>
    <div class="ml-auto flex gap-2">
        <form action="{{ route('admin.daily-content.fetch') }}" method="POST">
            @csrf
            <button class="text-xs bg-blue-600 text-white px-3 py-1.5 rounded-lg hover:bg-blue-500 transition flex items-center gap-1.5">
                <i class="fa-solid fa-rotate"></i> API'den Çek
            </button>
        </form>
        <a href="{{ route('admin.daily-content.create') }}"
           class="text-xs bg-brand text-white px-3 py-1.5 rounded-lg hover:bg-brand-light transition flex items-center gap-1.5">
            <i class="fa-solid fa-plus"></i> Yeni Ekle
        </a>
    </div>
</div>

<div class="space-y-3">
    @forelse($contents as $c)
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-4">
        <div class="flex items-start justify-between gap-3">
            <div class="flex items-center gap-2 mb-2">
                @php $typeColors = ['ayet'=>'brand','hadis'=>'amber','soz'=>'gray']; $tc = $typeColors[$c->type] ?? 'gray'; @endphp
                <span class="px-2 py-0.5 rounded-full text-xs font-semibold bg-{{ $tc }}-100 text-{{ $tc }}-700 capitalize">
                    {{ ['ayet'=>'Ayet','hadis'=>'Hadis','soz'=>'Söz'][$c->type] }}
                </span>
                <span class="text-xs text-gray-400">{{ $c->date->format('d.m.Y') }}</span>
                @if($c->is_manual)
                <span class="text-xs text-amber-600 flex items-center gap-1"><i class="fa-solid fa-pen text-xs"></i> Manuel</span>
                @endif
                @if(!$c->is_published)
                <span class="text-xs text-red-500"><i class="fa-solid fa-eye-slash text-xs"></i> Gizli</span>
                @endif
            </div>
            <div class="flex gap-1.5 shrink-0">
                <form action="{{ route('admin.daily-content.toggle', $c) }}" method="POST">
                    @csrf
                    <button class="text-xs px-2 py-1 rounded border border-gray-200 hover:border-brand transition">
                        {{ $c->is_published ? 'Gizle' : 'Yayınla' }}
                    </button>
                </form>
                <a href="{{ route('admin.daily-content.edit', $c) }}"
                   class="text-xs px-2 py-1 rounded border border-gray-200 hover:border-brand hover:text-brand transition">Düzenle</a>
                <form action="{{ route('admin.daily-content.destroy', $c) }}" method="POST" onsubmit="return confirm('Silinsin mi?')">
                    @csrf @method('DELETE')
                    <button class="text-xs px-2 py-1 rounded border border-red-200 text-red-500 hover:bg-red-50 transition">Sil</button>
                </form>
            </div>
        </div>
        @if($c->content_ar)
        <p class="text-right text-gray-500 text-base mb-1" style="font-family:serif;direction:rtl">{{ Str::limit($c->content_ar, 100) }}</p>
        @endif
        <p class="text-gray-700 text-sm leading-relaxed">{{ Str::limit($c->content_tr, 200) }}</p>
        @if($c->source)
        <p class="text-xs text-gray-400 mt-1.5">— {{ $c->source }}</p>
        @endif
    </div>
    @empty
    <div class="bg-white rounded-xl border border-gray-200 p-8 text-center text-gray-400">
        <i class="fa-solid fa-book-open text-4xl mb-2 block text-gray-200"></i>
        Kayıt yok.
    </div>
    @endforelse
</div>

@if($contents->hasPages())
<div class="mt-4">{{ $contents->appends(['type'=>$type])->links() }}</div>
@endif
@endsection
