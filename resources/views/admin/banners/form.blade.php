@extends('layouts.admin')
@section('title', $banner->exists ? 'Banner Düzenle' : 'Yeni Banner')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.banners.index') }}" class="text-sm text-gray-500 hover:text-brand flex items-center gap-1.5">
        <i class="fa-solid fa-arrow-left text-xs"></i> Bannerlar
    </a>
    <h1 class="text-xl font-bold text-gray-800 mt-1">
        {{ $banner->exists ? 'Banner Düzenle' : 'Yeni Banner Ekle' }}
    </h1>
</div>

@if($errors->any())
<div class="mb-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl text-sm space-y-1">
    @foreach($errors->all() as $e)<div>• {{ $e }}</div>@endforeach
</div>
@endif

<form action="{{ $banner->exists ? route('admin.banners.update', $banner) : route('admin.banners.store') }}"
      method="POST" class="max-w-2xl space-y-5">
    @csrf
    @if($banner->exists) @method('PUT') @endif

    {{-- Temel Bilgiler --}}
    <div class="bg-white rounded-xl border border-gray-100 p-5 space-y-4">
        <h2 class="font-semibold text-gray-700 text-sm border-b border-gray-100 pb-2">Temel Bilgiler</h2>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">İç Ad (admin görür) *</label>
            <input type="text" name="name" value="{{ old('name', $banner->name) }}"
                   class="w-full border border-gray-200 rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-brand/30"
                   placeholder="örn: Ramazan Kampanyası 2026">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Konum *</label>
            <select name="location"
                    class="w-full border border-gray-200 rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-brand/30">
                @foreach($locations as $key => $label)
                <option value="{{ $key }}" {{ old('location', $banner->location) === $key ? 'selected' : '' }}>
                    {{ $label }}
                </option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Sıra Numarası</label>
            <input type="number" name="sort_order" value="{{ old('sort_order', $banner->sort_order ?? 0) }}"
                   min="0" max="999"
                   class="w-full border border-gray-200 rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-brand/30">
            <p class="text-xs text-gray-400 mt-1">Küçük sayı → önce gösterilir</p>
        </div>
    </div>

    {{-- Görsel & Link --}}
    <div class="bg-white rounded-xl border border-gray-100 p-5 space-y-4">
        <h2 class="font-semibold text-gray-700 text-sm border-b border-gray-100 pb-2">Görsel & Bağlantı</h2>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Banner Görsel URL *</label>
            <input type="url" name="image_url" id="image_url_input" value="{{ old('image_url', $banner->image_url) }}"
                   class="w-full border border-gray-200 rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-brand/30"
                   placeholder="https://example.com/banner.jpg"
                   oninput="updatePreview(this.value)">
            <p class="text-xs text-gray-400 mt-1">Önerilen boyutlar: 728×90 (leaderboard) veya 300×250 (kare)</p>
        </div>

        {{-- Önizleme --}}
        <div id="preview-area" class="{{ old('image_url', $banner->image_url) ? '' : 'hidden' }}">
            <label class="block text-xs text-gray-500 mb-1">Önizleme</label>
            <div class="border border-gray-200 rounded-xl overflow-hidden bg-gray-50 max-w-sm">
                <img id="preview-img" src="{{ old('image_url', $banner->image_url) }}" alt="Önizleme"
                     class="w-full object-cover max-h-32">
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Alt Metin</label>
            <input type="text" name="alt_text" value="{{ old('alt_text', $banner->alt_text) }}"
                   class="w-full border border-gray-200 rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-brand/30"
                   placeholder="Banner açıklaması">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Tıklanınca Git (URL)</label>
            <input type="url" name="link_url" value="{{ old('link_url', $banner->link_url) }}"
                   class="w-full border border-gray-200 rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-brand/30"
                   placeholder="https://example.com">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Link Hedefi</label>
            <select name="link_target"
                    class="border border-gray-200 rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-brand/30">
                <option value="_blank" {{ old('link_target', $banner->link_target ?? '_blank') === '_blank' ? 'selected' : '' }}>Yeni sekmede aç</option>
                <option value="_self"  {{ old('link_target', $banner->link_target ?? '_blank') === '_self'  ? 'selected' : '' }}>Aynı sekmede aç</option>
            </select>
        </div>
    </div>

    {{-- Zamanlama & Durum --}}
    <div class="bg-white rounded-xl border border-gray-100 p-5 space-y-4">
        <h2 class="font-semibold text-gray-700 text-sm border-b border-gray-100 pb-2">Zamanlama & Durum</h2>

        <label class="flex items-center gap-3 cursor-pointer">
            <div class="relative">
                <input type="hidden" name="is_active" value="0">
                <input type="checkbox" name="is_active" value="1" class="sr-only peer"
                       {{ old('is_active', $banner->is_active ?? true) ? 'checked' : '' }}>
                <div class="w-10 h-6 bg-gray-200 peer-checked:bg-brand rounded-full transition"></div>
                <div class="absolute top-0.5 left-0.5 w-5 h-5 bg-white rounded-full shadow transition peer-checked:translate-x-4"></div>
            </div>
            <span class="text-sm text-gray-700">Banner aktif</span>
        </label>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Başlangıç Tarihi</label>
                <input type="datetime-local" name="starts_at"
                       value="{{ old('starts_at', $banner->starts_at?->format('Y-m-d\TH:i')) }}"
                       class="w-full border border-gray-200 rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-brand/30">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Bitiş Tarihi</label>
                <input type="datetime-local" name="ends_at"
                       value="{{ old('ends_at', $banner->ends_at?->format('Y-m-d\TH:i')) }}"
                       class="w-full border border-gray-200 rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-brand/30">
            </div>
        </div>
        <p class="text-xs text-gray-400">Boş bırakırsanız tarih sınırı olmadan gösterilir</p>
    </div>

    <div class="flex gap-3">
        <button type="submit"
                class="bg-brand text-white px-6 py-2.5 rounded-xl hover:bg-brand-light transition text-sm font-medium">
            <i class="fa-solid fa-floppy-disk mr-1"></i>
            {{ $banner->exists ? 'Güncelle' : 'Ekle' }}
        </button>
        <a href="{{ route('admin.banners.index') }}"
           class="px-6 py-2.5 rounded-xl border border-gray-200 text-gray-600 hover:bg-gray-50 transition text-sm">
            İptal
        </a>
    </div>
</form>

<script>
function updatePreview(url) {
    const area = document.getElementById('preview-area');
    const img  = document.getElementById('preview-img');
    if (url && url.startsWith('http')) {
        img.src = url;
        area.classList.remove('hidden');
    } else {
        area.classList.add('hidden');
    }
}
</script>
@endsection
