@extends('layouts.app')
@section('title', 'Radyo Mevlana')
@section('description', 'Radyo Mevlana – 24 saat kesintisiz İslami yayın. Ezan vakitleri, günün ayeti, hadisi ve daha fazlası.')

@section('content')

{{-- ── TOP BAR (son çalan ticker) ── --}}
<div class="bg-brand-dark text-white text-xs py-1.5 px-4 overflow-hidden">
    <div class="max-w-6xl mx-auto flex items-center gap-3">
        <span class="shrink-0 text-gold font-semibold flex items-center gap-1">
            <i class="fa-solid fa-bullhorn text-xs"></i> SON ÇALAN:
        </span>
        <div class="overflow-hidden flex-1">
            <div class="ticker whitespace-nowrap text-white/80" id="ticker-text">
                @if($history->count())
                    {{ $history->pluck('title')->join('  •  ') }}
                @else
                    Radyo Mevlana'ya Hoş Geldiniz — سَلاَمٌ قَوْلاً مِّن رَّبٍّ رَّحِيمٍ
                @endif
            </div>
        </div>
    </div>
</div>

{{-- ── HERO PLAYER ── --}}
<section class="bg-gradient-to-br from-brand-dark via-brand to-brand-light text-white py-14 px-4">
    <div class="max-w-6xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-10 items-center">

        {{-- Sol: büyük player kartı --}}
        <div class="bg-white/10 backdrop-blur rounded-2xl p-8 border border-white/20">
            <div class="flex items-start gap-5">
                <div class="relative shrink-0">
                    <div class="w-28 h-28 rounded-xl overflow-hidden bg-brand-dark/50 flex items-center justify-center border border-white/20">
                        <img id="album-art" src="" alt="" class="w-full h-full object-cover hidden">
                        <i id="art-icon" class="fa-solid fa-music text-white/40 text-4xl"></i>
                    </div>
                    <span id="live-badge" class="absolute -top-2 -right-2 bg-red-500 text-white text-xs font-bold px-1.5 py-0.5 rounded-full flex items-center gap-1"
                          style="{{ $stats['online'] ? '' : 'display:none' }}">
                        <span class="w-1.5 h-1.5 bg-white rounded-full animate-pulse"></span>CANLI
                    </span>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-white/50 text-xs uppercase tracking-wider mb-1">Şu An Çalıyor</p>
                    <p class="text-white font-bold text-lg leading-snug mb-1 truncate" id="hero-song">{{ $stats['current_song'] }}</p>
                    <p class="text-white/60 text-sm" id="hero-listeners">
                        <i class="fa-solid fa-headphones mr-1"></i>{{ $stats['listeners'] }} dinleyici
                    </p>
                </div>
            </div>

            {{-- Dalga animasyonu --}}
            <div id="hero-wave" class="flex items-end justify-center gap-1 h-8 my-5 paused">
                @for($i = 0; $i < 12; $i++)
                <span class="wave-bar" style="background:rgba(255,255,255,0.7);height:{{ [6,10,16,20,14,8,18,12,20,16,10,6][$i] }}px"></span>
                @endfor
            </div>

            {{-- Butonlar --}}
            <div class="flex items-center gap-3 mb-4">
                <button onclick="togglePlay()"
                    class="flex-1 bg-white text-brand font-semibold py-3 rounded-xl hover:bg-gray-50 transition flex items-center justify-center gap-2">
                    <i id="play-icon" class="fa-solid fa-play text-xl"></i>
                    <span id="play-label">Dinle</span>
                </button>
                <button onclick="document.getElementById('istek').scrollIntoView({behavior:'smooth'})"
                    class="flex-1 bg-gold text-white font-semibold py-3 rounded-xl hover:bg-gold-light transition flex items-center justify-center gap-2">
                    <i class="fa-solid fa-music"></i> Parça İste
                </button>
            </div>

            {{-- Ses seviyesi --}}
            <div class="flex items-center gap-2">
                <i class="fa-solid fa-volume-low text-white/50 text-sm"></i>
                <input type="range" id="volume-slider" min="0" max="1" step="0.05" value="0.8"
                    oninput="setVolume(this.value)"
                    class="flex-1 h-1 rounded-full accent-white cursor-pointer bg-white/20">
                <i class="fa-solid fa-volume-high text-white/50 text-sm"></i>
            </div>
        </div>

        {{-- Sağ: Ezan vakitleri --}}
        @if($prayerTimes)
        <div id="ezan">
            <div class="mb-4">
                <p class="arabic text-gold text-2xl leading-loose text-right">حَيَّ عَلَى الصَّلَاةِ</p>
                <h2 class="text-white font-bold text-xl mt-1">Ezan Vakitleri</h2>
                <p class="text-white/60 text-sm">Kuzey Kıbrıs (KKTC) — {{ today()->format('d.m.Y') }}</p>
                @if($nextPrayer)
                <div class="mt-2 bg-gold/20 border border-gold/40 rounded-lg px-3 py-2 inline-flex items-center gap-2 text-sm text-white">
                    <i class="fa-solid fa-clock text-gold"></i>
                    Sıradaki: <strong>{{ $nextPrayer['name'] }}</strong> – {{ $nextPrayer['time'] }}
                </div>
                @endif
            </div>

            <div class="grid grid-cols-2 gap-2">
                @foreach([
                    ['İmsak',  $prayerTimes->imsak,   'fa-moon'],
                    ['Sabah',  $prayerTimes->fajr,    'fa-sun'],
                    ['Güneş',  $prayerTimes->sunrise,  'fa-cloud-sun'],
                    ['Öğle',   $prayerTimes->dhuhr,   'fa-sun'],
                    ['İkindi', $prayerTimes->asr,     'fa-cloud'],
                    ['Akşam',  $prayerTimes->maghrib, 'fa-sunset'],
                    ['Yatsı',  $prayerTimes->isha,    'fa-star-and-crescent'],
                ] as [$name, $time, $icon])
                <div class="prayer-cell bg-white/10 rounded-xl px-4 py-3 flex items-center justify-between border border-white/10" data-time="{{ $time }}">
                    <div class="flex items-center gap-2 text-white/80">
                        <i class="fa-solid {{ $icon }} text-gold text-sm w-4"></i>
                        <span class="text-sm">{{ $name }}</span>
                    </div>
                    <span class="text-white font-semibold text-sm">{{ $time }}</span>
                </div>
                @endforeach
            </div>
        </div>
        @else
        <div class="text-white/60 text-center py-10">
            <i class="fa-solid fa-mosque text-5xl mb-3 block text-white/20"></i>
            Ezan vakitleri yükleniyor...
        </div>
        @endif
    </div>
</section>

{{-- ── ANASAYFA BANNER ── --}}
@if(isset($banners) && $banners['anasayfa']->isNotEmpty())
<div class="bg-gray-100 py-4 px-4">
    <div class="max-w-5xl mx-auto flex flex-wrap justify-center gap-4">
        @foreach($banners['anasayfa'] as $banner)
        @if($banner->link_url)
        <a href="{{ $banner->link_url }}" target="{{ $banner->link_target }}" rel="noopener">
            <img src="{{ $banner->image_url }}" alt="{{ $banner->alt_text ?? $banner->name }}"
                 class="max-h-24 rounded-xl object-contain shadow-sm">
        </a>
        @else
        <img src="{{ $banner->image_url }}" alt="{{ $banner->alt_text ?? $banner->name }}"
             class="max-h-24 rounded-xl object-contain shadow-sm">
        @endif
        @endforeach
    </div>
</div>
@endif

{{-- ── GÜNLÜK İÇERİK ── --}}
<section id="icerik" class="py-12 px-4 bg-white">
    <div class="max-w-6xl mx-auto">
        <h2 class="text-brand font-bold text-xl mb-6 flex items-center gap-2">
            <i class="fa-solid fa-book-open text-gold"></i> Günlük Manevi Köşe
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">

            {{-- Ayet --}}
            @if($dailyContents['ayet'])
            @php $ayet = $dailyContents['ayet'] @endphp
            <div class="bg-brand-pale border border-brand/20 rounded-2xl p-5">
                <div class="flex items-center gap-2 mb-3">
                    <div class="w-8 h-8 bg-brand rounded-lg flex items-center justify-center">
                        <i class="fa-solid fa-book-quran text-white text-sm"></i>
                    </div>
                    <span class="text-brand font-semibold text-sm">Günün Ayeti</span>
                </div>
                @if($ayet->content_ar)
                <p class="arabic text-gray-700 text-xl leading-loose mb-3 text-right">{{ $ayet->content_ar }}</p>
                @endif
                <p class="text-gray-700 text-sm leading-relaxed italic">"{{ $ayet->content_tr }}"</p>
                @if($ayet->source)
                <p class="text-brand/60 text-xs mt-3 font-medium">— {{ $ayet->source }}</p>
                @endif
            </div>
            @else
            <div class="bg-brand-pale border border-brand/20 rounded-2xl p-5 flex items-center justify-center text-brand/40 text-sm">
                <i class="fa-solid fa-book-quran mr-2"></i> Günün ayeti yükleniyor...
            </div>
            @endif

            {{-- Hadis --}}
            @if($dailyContents['hadis'])
            @php $hadis = $dailyContents['hadis'] @endphp
            <div class="bg-gold-pale border border-gold/30 rounded-2xl p-5">
                <div class="flex items-center gap-2 mb-3">
                    <div class="w-8 h-8 bg-gold rounded-lg flex items-center justify-center">
                        <i class="fa-solid fa-scroll text-white text-sm"></i>
                    </div>
                    <span class="text-gray-700 font-semibold text-sm">Günün Hadisi</span>
                </div>
                <p class="text-gray-700 text-sm leading-relaxed italic">"{{ $hadis->content_tr }}"</p>
                @if($hadis->source)
                <p class="text-gold/70 text-xs mt-3 font-medium">— {{ $hadis->source }}</p>
                @endif
            </div>
            @else
            <div class="bg-gold-pale border border-gold/30 rounded-2xl p-5 flex items-center justify-center text-gold/40 text-sm">
                <i class="fa-solid fa-scroll mr-2"></i> Günün hadisi yükleniyor...
            </div>
            @endif

            {{-- Söz --}}
            @if($dailyContents['soz'])
            @php $soz = $dailyContents['soz'] @endphp
            <div class="bg-gray-50 border border-gray-200 rounded-2xl p-5">
                <div class="flex items-center gap-2 mb-3">
                    <div class="w-8 h-8 bg-gray-700 rounded-lg flex items-center justify-center">
                        <i class="fa-solid fa-quote-left text-white text-sm"></i>
                    </div>
                    <span class="text-gray-700 font-semibold text-sm">Günün Sözü</span>
                </div>
                @if($soz->content_ar)
                <p class="arabic text-gray-600 text-lg leading-loose mb-3 text-right">{{ $soz->content_ar }}</p>
                @endif
                <p class="text-gray-700 text-sm leading-relaxed italic">"{{ $soz->content_tr }}"</p>
                @if($soz->source)
                <p class="text-gray-400 text-xs mt-3 font-medium">— {{ $soz->source }}</p>
                @endif
            </div>
            @else
            <div class="bg-gray-50 border border-gray-200 rounded-2xl p-5 flex items-center justify-center text-gray-300 text-sm">
                <i class="fa-solid fa-quote-left mr-2"></i> Günün sözü henüz eklenmedi.
            </div>
            @endif

        </div>
    </div>
</section>

{{-- ── SON ÇALANLAR ── --}}
<section id="gecmis" class="py-12 px-4 bg-gray-50">
    <div class="max-w-6xl mx-auto">
        <h2 class="text-brand font-bold text-xl mb-6 flex items-center gap-2">
            <i class="fa-solid fa-clock-rotate-left text-gold"></i> Son Çalan Parçalar
        </h2>
        <div id="history-list" class="grid grid-cols-1 sm:grid-cols-2 gap-3">
            @forelse($history as $i => $song)
            <div class="bg-white rounded-xl border border-gray-100 px-4 py-3 flex items-center gap-3 shadow-sm">
                <span class="text-gray-300 font-bold text-sm w-5 text-center shrink-0">{{ $i + 1 }}</span>
                @if($song->album_art)
                    <img src="{{ $song->album_art }}" alt="" class="w-10 h-10 rounded-lg object-cover shrink-0">
                @else
                    <div class="w-10 h-10 rounded-lg bg-brand-pale flex items-center justify-center shrink-0">
                        <i class="fa-solid fa-music text-brand/40 text-sm"></i>
                    </div>
                @endif
                <div class="min-w-0 flex-1">
                    <div class="font-medium text-gray-800 text-sm truncate">{{ $song->title }}</div>
                    @if($song->artist)
                    <div class="text-gray-400 text-xs truncate">{{ $song->artist }}</div>
                    @endif
                </div>
                <div class="text-gray-300 text-xs shrink-0">{{ $song->played_at->diffForHumans() }}</div>
            </div>
            @empty
            <div class="col-span-2 text-gray-400 text-sm text-center py-8">
                <i class="fa-solid fa-music text-3xl block mb-2 text-gray-200"></i>
                Henüz kayıt yok.
            </div>
            @endforelse
        </div>
    </div>
</section>

{{-- ── İSTEK PANELİ ── --}}
<section id="istek" class="py-12 px-4 bg-white">
    <div class="max-w-xl mx-auto">
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-14 h-14 bg-brand-pale rounded-2xl mb-3">
                <i class="fa-solid fa-paper-plane text-brand text-2xl"></i>
            </div>
            <h2 class="text-gray-800 font-bold text-2xl">Parça İsteği</h2>
            <p class="text-gray-400 text-sm mt-1">Dinlemek istediğiniz parçayı bizimle paylaşın</p>
        </div>

        @if(session('success'))
        <div class="bg-brand-pale border border-brand/30 text-brand rounded-xl px-4 py-3 mb-5 flex items-center gap-2 text-sm">
            <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
        </div>
        @endif

        <form action="{{ route('request.store') }}" method="POST" class="space-y-4">
            @csrf
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="text-gray-600 text-xs font-medium mb-1.5 block">Adınız *</label>
                    <input type="text" name="name" required value="{{ old('name') }}"
                        class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-brand text-gray-800 bg-gray-50"
                        placeholder="Adınız Soyadınız">
                    @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="text-gray-600 text-xs font-medium mb-1.5 block">Telefon</label>
                    <input type="text" name="phone" value="{{ old('phone') }}"
                        class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-brand text-gray-800 bg-gray-50"
                        placeholder="05xx xxx xx xx">
                </div>
            </div>
            <div>
                <label class="text-gray-600 text-xs font-medium mb-1.5 block">Şehir / Ülke</label>
                <input type="text" name="city" value="{{ old('city') }}"
                    class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-brand text-gray-800 bg-gray-50"
                    placeholder="İstanbul, Lefkoşa...">
            </div>
            <div>
                <label class="text-gray-600 text-xs font-medium mb-1.5 block">Parça Adı *</label>
                <input type="text" name="song_title" required value="{{ old('song_title') }}"
                    class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-brand text-gray-800 bg-gray-50"
                    placeholder="Parça adını yazın">
                @error('song_title')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="text-gray-600 text-xs font-medium mb-1.5 block">Sanatçı</label>
                <input type="text" name="artist" value="{{ old('artist') }}"
                    class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-brand text-gray-800 bg-gray-50"
                    placeholder="Sanatçı adı">
            </div>
            <div>
                <label class="text-gray-600 text-xs font-medium mb-1.5 block">Mesajınız</label>
                <textarea name="message" rows="3"
                    class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-brand text-gray-800 bg-gray-50 resize-none"
                    placeholder="Eklemek istediğiniz bir not...">{{ old('message') }}</textarea>
            </div>
            <button type="submit"
                class="w-full bg-brand hover:bg-brand-light text-white font-semibold py-3 rounded-xl flex items-center justify-center gap-2 transition">
                <i class="fa-solid fa-paper-plane"></i> İsteği Gönder
            </button>
        </form>
    </div>
</section>

@endsection

@section('scripts')
<script>
// Ses seviyesi
function setVolume(v) {
    if (audio) audio.volume = parseFloat(v);
}

// Ezan vakti vurgusu
function highlightPrayer() {
    const now = new Date().toTimeString().slice(0, 5);
    let last = null;
    document.querySelectorAll('.prayer-cell').forEach(cell => {
        cell.classList.remove('prayer-active');
        if (cell.dataset.time <= now) last = cell;
    });
    if (last) last.classList.add('prayer-active');
}
highlightPrayer();
setInterval(highlightPrayer, 60000);
</script>
@endsection
