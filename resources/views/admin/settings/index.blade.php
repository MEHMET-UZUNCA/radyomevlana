@extends('layouts.admin')
@section('title', 'Ayarlar')

@section('content')
<form action="{{ route('admin.settings.update') }}" method="POST" class="space-y-5 max-w-2xl">
    @csrf

    {{-- Site --}}
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-5">
        <h3 class="font-semibold text-gray-700 mb-4 flex items-center gap-2">
            <i class="fa-solid fa-globe text-brand text-sm"></i> Site Bilgileri
        </h3>
        <div class="space-y-3">
            <div>
                <label class="text-xs text-gray-500 mb-1.5 block">Site Adı</label>
                <input type="text" name="site_name" value="{{ $settings['site_name'] ?? 'Radyo Mevlana' }}"
                    class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-brand">
            </div>
            <div>
                <label class="text-xs text-gray-500 mb-1.5 block">Açıklama</label>
                <textarea name="site_description" rows="2"
                    class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-brand resize-none">{{ $settings['site_description'] ?? '' }}</textarea>
            </div>
            <div>
                <label class="text-xs text-gray-500 mb-1.5 block">Footer Metni</label>
                <input type="text" name="footer_text" value="{{ $settings['footer_text'] ?? '' }}"
                    class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-brand">
            </div>
            <div>
                <label class="text-xs text-gray-500 mb-1.5 block">Hakkımızda Metni</label>
                <textarea name="about_text" rows="3"
                    class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-brand resize-none">{{ $settings['about_text'] ?? '' }}</textarea>
            </div>
        </div>
    </div>

    {{-- Shoutcast --}}
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-5">
        <h3 class="font-semibold text-gray-700 mb-4 flex items-center gap-2">
            <i class="fa-solid fa-radio text-brand text-sm"></i> Shoutcast Ayarları
        </h3>
        <div class="space-y-3">
            <div>
                <label class="text-xs text-gray-500 mb-1.5 block">Sunucu URL (protokol + host + port)</label>
                <input type="text" name="shoutcast_url" value="{{ $settings['shoutcast_url'] ?? 'https://radyo.radyomevlana.com:9786' }}"
                    class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-brand"
                    placeholder="https://radyo.radyomevlana.com:9786">
            </div>
            <div>
                <label class="text-xs text-gray-500 mb-1.5 block">Stream ID (SID)</label>
                <input type="number" name="shoutcast_sid" value="{{ $settings['shoutcast_sid'] ?? '1' }}"
                    class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-brand" min="1">
            </div>
        </div>
    </div>

    {{-- Ezan --}}
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-5">
        <h3 class="font-semibold text-gray-700 mb-4 flex items-center gap-2">
            <i class="fa-solid fa-mosque text-brand text-sm"></i> Ezan Vakti API
        </h3>
        <div class="grid grid-cols-3 gap-3">
            <div>
                <label class="text-xs text-gray-500 mb-1.5 block">Şehir</label>
                <input type="text" name="prayer_city" value="{{ $settings['prayer_city'] ?? 'Lefkosa' }}"
                    class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-brand">
            </div>
            <div>
                <label class="text-xs text-gray-500 mb-1.5 block">Ülke</label>
                <input type="text" name="prayer_country" value="{{ $settings['prayer_country'] ?? 'Cyprus' }}"
                    class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-brand">
            </div>
            <div>
                <label class="text-xs text-gray-500 mb-1.5 block">Metot (Diyanet=13)</label>
                <input type="number" name="prayer_method" value="{{ $settings['prayer_method'] ?? '13' }}"
                    class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-brand" min="0">
            </div>
        </div>
    </div>

    {{-- İletişim --}}
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-5">
        <h3 class="font-semibold text-gray-700 mb-4 flex items-center gap-2">
            <i class="fa-solid fa-phone text-brand text-sm"></i> İletişim
        </h3>
        <div class="grid grid-cols-2 gap-3">
            @foreach(['contact_email'=>'E-posta','contact_phone'=>'Telefon','contact_whatsapp'=>'WhatsApp'] as $key=>$label)
            <div>
                <label class="text-xs text-gray-500 mb-1.5 block">{{ $label }}</label>
                <input type="text" name="{{ $key }}" value="{{ $settings[$key] ?? '' }}"
                    class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-brand">
            </div>
            @endforeach
        </div>
    </div>

    {{-- Sosyal Medya --}}
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-5">
        <h3 class="font-semibold text-gray-700 mb-4 flex items-center gap-2">
            <i class="fa-solid fa-share-nodes text-brand text-sm"></i> Sosyal Medya
        </h3>
        <div class="space-y-3">
            @foreach(['facebook_url'=>'Facebook','twitter_url'=>'X (Twitter)','instagram_url'=>'Instagram','youtube_url'=>'YouTube'] as $key=>$label)
            <div>
                <label class="text-xs text-gray-500 mb-1.5 block">{{ $label }}</label>
                <input type="url" name="{{ $key }}" value="{{ $settings[$key] ?? '' }}"
                    class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-brand"
                    placeholder="https://...">
            </div>
            @endforeach
        </div>
    </div>

    <div>
        <label class="text-xs text-gray-500 mb-1.5 block">İletişim / Alan Adı</label>
        <input type="text" name="site_contact" value="{{ $settings['site_contact'] ?? 'www.radyomevlana.com' }}"
            class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-brand">
    </div>

    <button type="submit" class="bg-brand text-white px-6 py-2.5 rounded-xl text-sm font-semibold hover:bg-brand-light transition">
        <i class="fa-solid fa-floppy-disk mr-2"></i> Tüm Ayarları Kaydet
    </button>
</form>

{{-- Cron Bilgisi --}}
<div class="mt-8 bg-white rounded-xl border border-gray-200 shadow-sm p-5 max-w-2xl">
    <h3 class="font-semibold text-gray-700 mb-4 flex items-center gap-2">
        <i class="fa-solid fa-clock text-brand text-sm"></i> Zamanlayıcı (Cron) Komutu
    </h3>
    <p class="text-sm text-gray-500 mb-3">Sunucunuzun crontab'ına aşağıdaki satırı ekleyin (her dakika çalışır):</p>
    <div class="bg-gray-900 rounded-lg px-4 py-3 font-mono text-sm text-green-400 flex items-center justify-between gap-3">
        <span id="cron-cmd">* * * * * {{ PHP_BINARY }} {{ base_path('artisan') }} schedule:run >> /dev/null 2>&1</span>
        <button onclick="copyCron()" class="text-white/50 hover:text-white transition text-xs shrink-0">
            <i class="fa-solid fa-copy"></i> Kopyala
        </button>
    </div>
    <div class="mt-3 text-xs text-gray-400 space-y-1">
        <p><i class="fa-solid fa-circle-info mr-1"></i> Zamanlayıcı aşağıdaki görevleri yönetir:</p>
        <ul class="ml-4 space-y-0.5 list-disc text-gray-400">
            <li>Her 30 saniyede: Shoutcast parça güncelleme</li>
            <li>Her gün 00:05: Günün ayeti, hadisi ve ezan vakitleri</li>
            <li>Günde 2 kez (08:00 ve 20:00): KKTC hutbe ve duyurular</li>
            <li>Her gün 09:00: Evkaf haberleri</li>
        </ul>
    </div>
</div>

@section('scripts')
<script>
function copyCron() {
    const text = document.getElementById('cron-cmd').textContent;
    navigator.clipboard.writeText(text).then(() => {
        const btn = event.target.closest('button');
        btn.innerHTML = '<i class="fa-solid fa-check"></i> Kopyalandı';
        setTimeout(() => { btn.innerHTML = '<i class="fa-solid fa-copy"></i> Kopyala'; }, 2000);
    });
}
</script>
@endsection

@endsection
