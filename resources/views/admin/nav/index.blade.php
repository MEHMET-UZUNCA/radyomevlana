@extends('layouts.admin')
@section('title', 'Menü Yönetimi')

@section('content')
<div class="flex justify-end mb-5">
    <a href="{{ route('admin.nav.create') }}"
       class="text-xs bg-brand text-white px-4 py-2 rounded-lg hover:bg-brand-light transition flex items-center gap-1.5">
        <i class="fa-solid fa-plus"></i> Yeni Menü Öğesi
    </a>
</div>

<div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
    <table class="w-full text-sm">
        <thead>
            <tr class="border-b border-gray-100 bg-gray-50 text-xs text-gray-500 uppercase tracking-wide">
                <th class="px-4 py-3 text-left">Sıra</th>
                <th class="px-4 py-3 text-left">Etiket</th>
                <th class="px-4 py-3 text-left">URL</th>
                <th class="px-4 py-3 text-left">Konum</th>
                <th class="px-4 py-3 text-left">Durum</th>
                <th class="px-4 py-3 text-right">İşlem</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-50">
            @forelse($items as $item)
            <tr class="hover:bg-gray-50">
                <td class="px-4 py-3 text-gray-400 font-mono">{{ $item->sort_order }}</td>
                <td class="px-4 py-3">
                    <div class="flex items-center gap-2">
                        @if($item->icon)<i class="{{ $item->icon }} text-brand/60 text-xs w-4"></i>@endif
                        <span class="font-medium text-gray-800">{{ $item->label }}</span>
                        @if($item->is_button)
                        <span class="text-xs bg-brand/10 text-brand px-1.5 py-0.5 rounded">Buton</span>
                        @endif
                    </div>
                </td>
                <td class="px-4 py-3 text-gray-500 font-mono text-xs">{{ $item->url }}</td>
                <td class="px-4 py-3">
                    <span class="text-xs px-2 py-0.5 rounded-full
                        {{ $item->location === 'header' ? 'bg-blue-50 text-blue-600' : ($item->location === 'footer' ? 'bg-purple-50 text-purple-600' : 'bg-green-50 text-green-600') }}">
                        {{ $item->location === 'header' ? 'Üst Menü' : ($item->location === 'footer' ? 'Alt Menü' : 'Her İkisi') }}
                    </span>
                </td>
                <td class="px-4 py-3">
                    @if($item->is_active)
                    <span class="text-xs text-green-600 flex items-center gap-1"><i class="fa-solid fa-circle-check"></i> Aktif</span>
                    @else
                    <span class="text-xs text-gray-400 flex items-center gap-1"><i class="fa-solid fa-circle-xmark"></i> Pasif</span>
                    @endif
                </td>
                <td class="px-4 py-3 text-right">
                    <div class="flex items-center justify-end gap-1">
                        <a href="{{ route('admin.nav.edit', $item) }}"
                           class="text-xs px-2 py-1 rounded border border-gray-200 hover:border-brand hover:text-brand transition">Düzenle</a>
                        <form action="{{ route('admin.nav.destroy', $item) }}" method="POST" onsubmit="return confirm('Silinsin mi?')">
                            @csrf @method('DELETE')
                            <button class="text-xs px-2 py-1 rounded border border-red-200 text-red-500 hover:bg-red-50 transition">Sil</button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="px-4 py-8 text-center text-gray-400 text-sm">
                    Henüz menü öğesi eklenmedi.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4 bg-blue-50 border border-blue-200 rounded-lg p-4 text-sm text-blue-700">
    <i class="fa-solid fa-circle-info mr-2"></i>
    <strong>Sayfa oluşturmak için:</strong> Önce "Sayfalar" bölümünden içerikli bir sayfa oluşturun,
    ardından burada URL olarak <code class="bg-blue-100 px-1 rounded">/sayfa/slug-adi</code> girin.
</div>
@endsection
