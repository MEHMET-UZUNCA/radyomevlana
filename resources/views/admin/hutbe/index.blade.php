@extends('layouts.admin')
@section('title', 'Hutbeler')

@section('content')
<div class="flex items-center gap-3 mb-5 flex-wrap">
    <div class="flex gap-2 ml-auto">
        <form action="{{ route('admin.hutbe.scrape') }}" method="POST">
            @csrf
            <button class="text-xs bg-blue-600 text-white px-3 py-1.5 rounded-lg hover:bg-blue-500 transition flex items-center gap-1.5">
                <i class="fa-solid fa-rotate"></i> KKTC'den Çek (Son 20)
            </button>
        </form>
        <a href="{{ route('admin.hutbe.create') }}"
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
                <th class="text-left px-4 py-3 text-gray-500 font-medium">Tarih</th>
                <th class="text-left px-4 py-3 text-gray-500 font-medium">İndir</th>
                <th class="text-left px-4 py-3 text-gray-500 font-medium">Kaynak</th>
                <th class="px-4 py-3"></th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-50">
            @forelse($hutbes as $h)
            <tr class="hover:bg-gray-50">
                <td class="px-4 py-3 font-medium text-gray-800 max-w-xs">
                    <div class="truncate">{{ $h->title }}</div>
                </td>
                <td class="px-4 py-3 text-gray-500 whitespace-nowrap">{{ $h->date->format('d.m.Y') }}</td>
                <td class="px-4 py-3">
                    <div class="flex gap-1">
                        @if($h->pdf_url)
                        <a href="{{ route('hutbe.download', [$h, 'pdf']) }}" target="_blank"
                           class="text-xs bg-red-50 text-red-600 px-2 py-1 rounded border border-red-200">PDF</a>
                        @endif
                        @if($h->word_url)
                        <a href="{{ route('hutbe.download', [$h, 'word']) }}" target="_blank"
                           class="text-xs bg-blue-50 text-blue-600 px-2 py-1 rounded border border-blue-200">Word</a>
                        @endif
                    </div>
                </td>
                <td class="px-4 py-3 text-xs">
                    <span class="{{ $h->is_manual ? 'text-amber-600' : 'text-green-600' }}">
                        {{ $h->is_manual ? 'Manuel' : 'KKTC' }}
                    </span>
                    @if(!$h->is_published)
                    <span class="text-red-500 ml-1"><i class="fa-solid fa-eye-slash"></i></span>
                    @endif
                </td>
                <td class="px-4 py-3">
                    <div class="flex gap-1">
                        <a href="{{ route('admin.hutbe.edit', $h) }}"
                           class="text-xs px-2 py-1 rounded border border-gray-200 hover:border-brand hover:text-brand transition">Düzenle</a>
                        <form action="{{ route('admin.hutbe.destroy', $h) }}" method="POST" onsubmit="return confirm('Silinsin mi?')">
                            @csrf @method('DELETE')
                            <button class="text-xs px-2 py-1 rounded border border-red-200 text-red-500 hover:bg-red-50 transition">Sil</button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="5" class="px-4 py-8 text-center text-gray-400">Kayıt yok. "KKTC'den Çek" butonuna basın.</td></tr>
            @endforelse
        </tbody>
    </table>
    @if($hutbes->hasPages())
    <div class="px-4 py-3 border-t border-gray-100">{{ $hutbes->links() }}</div>
    @endif
</div>
@endsection
