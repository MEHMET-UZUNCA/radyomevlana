@extends('layouts.admin')
@section('title', 'SEO Ayarları')

@section('content')
<div class="flex justify-end mb-5">
    <a href="{{ route('admin.seo.create') }}"
       class="text-xs bg-brand text-white px-4 py-2 rounded-lg hover:bg-brand-light transition flex items-center gap-1.5">
        <i class="fa-solid fa-plus"></i> Yeni SEO Kaydı
    </a>
</div>

<div class="mb-4 bg-yellow-50 border border-yellow-200 rounded-lg p-3 text-sm text-yellow-800">
    <i class="fa-solid fa-lightbulb mr-2"></i>
    Her sayfa için ayrı SEO ayarı ekleyin. <strong>Yol</strong> alanına <code class="bg-yellow-100 px-1 rounded">/</code> (ana sayfa),
    <code class="bg-yellow-100 px-1 rounded">/hutbeler</code>, <code class="bg-yellow-100 px-1 rounded">/duyurular</code> gibi değerler girin.
</div>

<div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
    <table class="w-full text-sm">
        <thead>
            <tr class="border-b border-gray-100 bg-gray-50 text-xs text-gray-500 uppercase tracking-wide">
                <th class="px-4 py-3 text-left">Yol (Path)</th>
                <th class="px-4 py-3 text-left">Başlık</th>
                <th class="px-4 py-3 text-left">Açıklama</th>
                <th class="px-4 py-3 text-right">İşlem</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-50">
            @forelse($seos as $seo)
            <tr class="hover:bg-gray-50">
                <td class="px-4 py-3 font-mono text-xs text-brand">{{ $seo->path }}</td>
                <td class="px-4 py-3 text-gray-800 max-w-xs truncate">{{ $seo->title ?: '—' }}</td>
                <td class="px-4 py-3 text-gray-500 text-xs max-w-xs truncate">{{ $seo->description ?: '—' }}</td>
                <td class="px-4 py-3 text-right">
                    <div class="flex items-center justify-end gap-1">
                        <a href="{{ route('admin.seo.edit', $seo) }}"
                           class="text-xs px-2 py-1 rounded border border-gray-200 hover:border-brand hover:text-brand transition">Düzenle</a>
                        <form action="{{ route('admin.seo.destroy', $seo) }}" method="POST" onsubmit="return confirm('Silinsin mi?')">
                            @csrf @method('DELETE')
                            <button class="text-xs px-2 py-1 rounded border border-red-200 text-red-500 hover:bg-red-50 transition">Sil</button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="px-4 py-8 text-center text-gray-400 text-sm">
                    Henüz SEO kaydı eklenmedi.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
