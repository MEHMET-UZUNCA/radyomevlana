@extends('layouts.admin')
@section('title', 'Menü Öğesi Düzenle')

@section('content')
<div class="max-w-2xl">
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
        <form action="{{ route('admin.nav.update', $navItem) }}" method="POST" class="space-y-4">
            @csrf @method('PUT')

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="text-xs text-gray-500 mb-1.5 block font-medium">Etiket *</label>
                    <input type="text" name="label" required value="{{ old('label', $navItem->label) }}"
                        class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-brand">
                </div>
                <div>
                    <label class="text-xs text-gray-500 mb-1.5 block font-medium">Sıra</label>
                    <input type="number" name="sort_order" value="{{ old('sort_order', $navItem->sort_order) }}" min="0"
                        class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-brand">
                </div>
            </div>

            <div>
                <label class="text-xs text-gray-500 mb-1.5 block font-medium">URL *</label>
                <input type="text" name="url" required value="{{ old('url', $navItem->url) }}"
                    class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-brand font-mono">
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="text-xs text-gray-500 mb-1.5 block font-medium">Konum *</label>
                    <select name="location" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-brand">
                        <option value="header" {{ old('location', $navItem->location) === 'header' ? 'selected' : '' }}>Üst Menü</option>
                        <option value="footer" {{ old('location', $navItem->location) === 'footer' ? 'selected' : '' }}>Alt Menü</option>
                        <option value="both"   {{ old('location', $navItem->location) === 'both'   ? 'selected' : '' }}>Her İkisi</option>
                    </select>
                </div>
                <div>
                    <label class="text-xs text-gray-500 mb-1.5 block font-medium">Hedef</label>
                    <select name="target" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-brand">
                        <option value="_self"  {{ old('target', $navItem->target) === '_self'  ? 'selected' : '' }}>Aynı Sekme</option>
                        <option value="_blank" {{ old('target', $navItem->target) === '_blank' ? 'selected' : '' }}>Yeni Sekme</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="text-xs text-gray-500 mb-1.5 block font-medium">İkon</label>
                <input type="text" name="icon" value="{{ old('icon', $navItem->icon) }}"
                    class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-brand font-mono"
                    placeholder="fa-solid fa-home">
            </div>

            <div class="flex items-center gap-6">
                <div class="flex items-center gap-2">
                    <input type="checkbox" name="is_active" id="is_active" value="1"
                           {{ old('is_active', $navItem->is_active) ? 'checked' : '' }} class="w-4 h-4 accent-brand">
                    <label for="is_active" class="text-sm text-gray-600">Aktif</label>
                </div>
                <div class="flex items-center gap-2">
                    <input type="checkbox" name="is_button" id="is_button" value="1"
                           {{ old('is_button', $navItem->is_button) ? 'checked' : '' }} class="w-4 h-4 accent-brand">
                    <label for="is_button" class="text-sm text-gray-600">Buton stili</label>
                </div>
            </div>

            <div class="flex gap-3">
                <button type="submit" class="bg-brand text-white px-5 py-2 rounded-lg text-sm font-medium hover:bg-brand-light transition">Güncelle</button>
                <a href="{{ route('admin.nav.index') }}" class="border border-gray-200 text-gray-600 px-5 py-2 rounded-lg text-sm hover:border-gray-300 transition">İptal</a>
            </div>
        </form>
    </div>
</div>
@endsection
