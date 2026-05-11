@extends('layouts.admin')
@section('title', 'Parça Geçmişi')

@section('content')
<div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 border-b border-gray-200">
            <tr>
                <th class="text-left px-4 py-3 text-gray-500 font-medium">Parça</th>
                <th class="text-left px-4 py-3 text-gray-500 font-medium">Sanatçı</th>
                <th class="text-left px-4 py-3 text-gray-500 font-medium">Tarih</th>
                <th class="px-4 py-3"></th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-50">
            @forelse($history as $s)
            <tr class="hover:bg-gray-50">
                <td class="px-4 py-3 flex items-center gap-3">
                    @if($s->album_art)
                    <img src="{{ $s->album_art }}" alt="" class="w-9 h-9 rounded-lg object-cover shrink-0">
                    @else
                    <div class="w-9 h-9 rounded-lg bg-gray-100 flex items-center justify-center shrink-0">
                        <i class="fa-solid fa-music text-gray-300 text-xs"></i>
                    </div>
                    @endif
                    <span class="font-medium text-gray-800">{{ $s->title }}</span>
                </td>
                <td class="px-4 py-3 text-gray-500">{{ $s->artist ?? '–' }}</td>
                <td class="px-4 py-3 text-gray-400 text-xs whitespace-nowrap">{{ $s->played_at->format('d.m.Y H:i') }}</td>
                <td class="px-4 py-3">
                    <form action="{{ route('admin.history.destroy', $s) }}" method="POST" onsubmit="return confirm('Silinsin mi?')">
                        @csrf @method('DELETE')
                        <button class="text-xs px-2 py-1 rounded border border-red-200 text-red-500 hover:bg-red-50 transition">Sil</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="4" class="px-4 py-8 text-center text-gray-400">Kayıt yok.</td></tr>
            @endforelse
        </tbody>
    </table>
    @if($history->hasPages())
    <div class="px-4 py-3 border-t border-gray-100">{{ $history->links() }}</div>
    @endif
</div>
@endsection
