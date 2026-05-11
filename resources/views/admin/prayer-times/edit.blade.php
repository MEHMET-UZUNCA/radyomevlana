@extends('layouts.admin')
@section('title', 'Ezan Vakti Düzenle')

@section('content')
<div class="max-w-lg">
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
        <h3 class="font-semibold text-gray-700 mb-4">{{ $prayerTime->date->format('d.m.Y') }} – Vakitler</h3>
        <form action="{{ route('admin.prayer-times.update', $prayerTime) }}" method="POST" class="space-y-3">
            @csrf @method('PUT')
            <div class="grid grid-cols-2 gap-3">
                @foreach(['imsak'=>'İmsak','fajr'=>'Sabah','sunrise'=>'Güneş','dhuhr'=>'Öğle','asr'=>'İkindi','maghrib'=>'Akşam','isha'=>'Yatsı'] as $field => $name)
                <div>
                    <label class="text-xs text-gray-500 mb-1 block">{{ $name }}</label>
                    <input type="time" name="{{ $field }}" required value="{{ $prayerTime->$field }}"
                        class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-brand">
                    @error($field) <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                @endforeach
            </div>
            <div class="flex gap-3 pt-2">
                <button type="submit" class="bg-brand text-white px-5 py-2 rounded-lg text-sm font-medium hover:bg-brand-light transition">
                    Kaydet
                </button>
                <a href="{{ route('admin.prayer-times.index') }}" class="border border-gray-200 text-gray-600 px-5 py-2 rounded-lg text-sm hover:border-gray-300 transition">
                    İptal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
