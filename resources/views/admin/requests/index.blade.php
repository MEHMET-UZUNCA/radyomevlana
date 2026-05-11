@extends('layouts.admin')
@section('title', 'Parça İstekleri')

@section('content')
{{-- Filtre --}}
<div class="flex gap-2 mb-5 flex-wrap">
    @foreach(['pending'=>'Bekleyen','approved'=>'Onaylı','played'=>'Çalındı','rejected'=>'Reddedildi','all'=>'Tümü'] as $val => $label)
    <a href="{{ route('admin.requests.index', ['status'=>$val]) }}"
       class="px-3 py-1.5 rounded-lg text-sm font-medium transition
              {{ $status === $val ? 'bg-brand text-white' : 'bg-white text-gray-600 border border-gray-200 hover:border-brand' }}">
        {{ $label }}
    </a>
    @endforeach
</div>

<div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 border-b border-gray-200">
            <tr>
                <th class="text-left px-4 py-3 text-gray-500 font-medium">Ad / Şehir</th>
                <th class="text-left px-4 py-3 text-gray-500 font-medium">İstenen Parça</th>
                <th class="text-left px-4 py-3 text-gray-500 font-medium">Mesaj</th>
                <th class="text-left px-4 py-3 text-gray-500 font-medium">Durum</th>
                <th class="text-left px-4 py-3 text-gray-500 font-medium">Tarih</th>
                <th class="px-4 py-3"></th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-50">
            @forelse($requests as $req)
            <tr class="hover:bg-gray-50">
                <td class="px-4 py-3">
                    <div class="font-medium text-gray-800">{{ $req->name }}</div>
                    <div class="text-xs text-gray-400">{{ $req->city }} {{ $req->phone ? '· '.$req->phone : '' }}</div>
                </td>
                <td class="px-4 py-3">
                    <div class="font-medium text-gray-800">{{ $req->song_title }}</div>
                    @if($req->artist)<div class="text-xs text-gray-400">{{ $req->artist }}</div>@endif
                </td>
                <td class="px-4 py-3 text-gray-500 text-xs max-w-xs">{{ Str::limit($req->message, 60) }}</td>
                <td class="px-4 py-3">
                    @php $colors = ['pending'=>'amber','approved'=>'blue','played'=>'green','rejected'=>'red']; $c = $colors[$req->status] ?? 'gray'; @endphp
                    <span class="px-2 py-0.5 rounded-full text-xs font-semibold bg-{{ $c }}-100 text-{{ $c }}-700">
                        {{ ['pending'=>'Bekliyor','approved'=>'Onaylı','played'=>'Çalındı','rejected'=>'Reddedildi'][$req->status] }}
                    </span>
                </td>
                <td class="px-4 py-3 text-gray-400 text-xs whitespace-nowrap">{{ $req->created_at->format('d.m.Y H:i') }}</td>
                <td class="px-4 py-3">
                    <div class="flex items-center gap-1 flex-wrap">
                        @foreach(['approved'=>'Onayla','played'=>'Çalındı','rejected'=>'Reddet'] as $s=>$lbl)
                        @if($req->status !== $s)
                        <form action="{{ route('admin.requests.status', [$req, $s]) }}" method="POST">
                            @csrf @method('PATCH')
                            <button class="text-xs px-2 py-1 rounded border border-gray-200 hover:border-brand hover:text-brand transition">{{ $lbl }}</button>
                        </form>
                        @endif
                        @endforeach
                        <form action="{{ route('admin.requests.destroy', $req) }}" method="POST" onsubmit="return confirm('Silinsin mi?')">
                            @csrf @method('DELETE')
                            <button class="text-xs px-2 py-1 rounded border border-red-200 text-red-500 hover:bg-red-50 transition">Sil</button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="6" class="px-4 py-8 text-center text-gray-400">Kayıt yok.</td></tr>
            @endforelse
        </tbody>
    </table>
    @if($requests->hasPages())
    <div class="px-4 py-3 border-t border-gray-100">{{ $requests->appends(['status'=>$status])->links() }}</div>
    @endif
</div>
@endsection
