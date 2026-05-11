@extends('layouts.admin')
@section('title', 'Ezan Vakitleri')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-2 gap-5 mb-6">

    {{-- Bugünün vakitleri + API butonu --}}
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-5">
        <div class="flex items-center justify-between mb-4">
            <h3 class="font-semibold text-gray-700">Bugün – {{ today()->format('d.m.Y') }}</h3>
            <form action="{{ route('admin.prayer-times.fetch') }}" method="POST">
                @csrf
                <button class="text-xs bg-brand text-white px-3 py-1.5 rounded-lg hover:bg-brand-light transition flex items-center gap-1.5">
                    <i class="fa-solid fa-rotate"></i> API'den Çek
                </button>
            </form>
        </div>
        @if($today)
        <div class="grid grid-cols-2 gap-2 text-sm mb-4">
            @foreach(['imsak'=>'İmsak','fajr'=>'Sabah','sunrise'=>'Güneş','dhuhr'=>'Öğle','asr'=>'İkindi','maghrib'=>'Akşam','isha'=>'Yatsı'] as $field => $name)
            <div class="flex justify-between bg-gray-50 rounded-lg px-3 py-2">
                <span class="text-gray-500">{{ $name }}</span>
                <span class="font-semibold text-gray-800">{{ $today->$field }}</span>
            </div>
            @endforeach
        </div>
        @if($today->is_manual)
        <p class="text-xs text-amber-600 flex items-center gap-1"><i class="fa-solid fa-pen"></i> Manuel girildi</p>
        @else
        <p class="text-xs text-green-600 flex items-center gap-1"><i class="fa-solid fa-cloud-arrow-down"></i> API'den çekildi</p>
        @endif
        @else
        <p class="text-gray-400 text-sm text-center py-4">Bugün için kayıt yok. API'den çekin veya manuel girin.</p>
        @endif
    </div>

    {{-- Manuel Giriş --}}
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-5">
        <h3 class="font-semibold text-gray-700 mb-4">Manuel Giriş</h3>
        <form action="{{ route('admin.prayer-times.store') }}" method="POST" class="space-y-3">
            @csrf
            <div>
                <label class="text-xs text-gray-500 mb-1 block">Tarih</label>
                <input type="date" name="date" value="{{ today()->toDateString() }}" required
                    class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-brand">
            </div>
            <div class="grid grid-cols-2 gap-2">
                @foreach(['imsak'=>'İmsak','fajr'=>'Sabah','sunrise'=>'Güneş','dhuhr'=>'Öğle','asr'=>'İkindi','maghrib'=>'Akşam','isha'=>'Yatsı'] as $field => $name)
                <div>
                    <label class="text-xs text-gray-500 mb-1 block">{{ $name }}</label>
                    <input type="time" name="{{ $field }}" required
                        value="{{ $today?->$field ?? '' }}"
                        class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-brand">
                </div>
                @endforeach
            </div>
            <button type="submit" class="w-full bg-brand text-white py-2 rounded-lg text-sm font-medium hover:bg-brand-light transition">
                Kaydet
            </button>
        </form>
    </div>
</div>

{{-- Tüm kayıtlar --}}
<div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
    <div class="px-5 py-3 border-b border-gray-100 font-medium text-gray-600 text-sm">Tüm Kayıtlar</div>
    <table class="w-full text-sm">
        <thead class="bg-gray-50">
            <tr>
                <th class="text-left px-4 py-3 text-gray-500 font-medium">Tarih</th>
                <th class="text-left px-4 py-3 text-gray-500 font-medium">İmsak</th>
                <th class="text-left px-4 py-3 text-gray-500 font-medium">Sabah</th>
                <th class="text-left px-4 py-3 text-gray-500 font-medium">Öğle</th>
                <th class="text-left px-4 py-3 text-gray-500 font-medium">İkindi</th>
                <th class="text-left px-4 py-3 text-gray-500 font-medium">Akşam</th>
                <th class="text-left px-4 py-3 text-gray-500 font-medium">Yatsı</th>
                <th class="text-left px-4 py-3 text-gray-500 font-medium">Kaynak</th>
                <th class="px-4 py-3"></th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-50">
            @forelse($times as $pt)
            <tr class="hover:bg-gray-50">
                <td class="px-4 py-2.5 font-medium text-gray-800">{{ $pt->date->format('d.m.Y') }}</td>
                <td class="px-4 py-2.5 text-gray-600">{{ $pt->imsak }}</td>
                <td class="px-4 py-2.5 text-gray-600">{{ $pt->fajr }}</td>
                <td class="px-4 py-2.5 text-gray-600">{{ $pt->dhuhr }}</td>
                <td class="px-4 py-2.5 text-gray-600">{{ $pt->asr }}</td>
                <td class="px-4 py-2.5 text-gray-600">{{ $pt->maghrib }}</td>
                <td class="px-4 py-2.5 text-gray-600">{{ $pt->isha }}</td>
                <td class="px-4 py-2.5">
                    <span class="text-xs {{ $pt->is_manual ? 'text-amber-600' : 'text-green-600' }}">
                        {{ $pt->is_manual ? 'Manuel' : 'API' }}
                    </span>
                </td>
                <td class="px-4 py-2.5">
                    <div class="flex gap-1">
                        <a href="{{ route('admin.prayer-times.edit', $pt) }}"
                           class="text-xs px-2 py-1 rounded border border-gray-200 hover:border-brand hover:text-brand transition">Düzenle</a>
                        <form action="{{ route('admin.prayer-times.destroy', $pt) }}" method="POST" onsubmit="return confirm('Silinsin mi?')">
                            @csrf @method('DELETE')
                            <button class="text-xs px-2 py-1 rounded border border-red-200 text-red-500 hover:bg-red-50 transition">Sil</button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="9" class="px-4 py-8 text-center text-gray-400">Kayıt yok.</td></tr>
            @endforelse
        </tbody>
    </table>
    @if($times->hasPages())
    <div class="px-4 py-3 border-t border-gray-100">{{ $times->links() }}</div>
    @endif
</div>
@endsection
