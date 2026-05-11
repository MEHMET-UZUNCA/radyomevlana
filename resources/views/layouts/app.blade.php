<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{-- SEO Meta Tags --}}
    @php
        $seoTitle       = $pageSeo?->title ?? null;
        $seoDescription = $pageSeo?->description ?? null;
        $seoKeywords    = $pageSeo?->keywords ?? null;
        $seoOgTitle     = $pageSeo?->og_title ?: ($seoTitle ?? ($siteName ?? 'Radyo Mevlana'));
        $seoOgImage     = $pageSeo?->og_image ?? null;
        $defaultDesc    = 'Radyo Mevlana – 24 saat kesintisiz İslami yayın, ezan vakitleri, günün ayeti ve hadisi.';
        $defaultDescSh  = 'Radyo Mevlana – 24 saat kesintisiz İslami yayın.';
    @endphp
    <title>
        @if($seoTitle)
            {{ $seoTitle }}
        @else
            @yield('title', $siteName ?? 'Radyo Mevlana') – İslami Radyo
        @endif
    </title>
    <meta name="description" content="{{ $seoDescription ?? \Illuminate\Support\Str::limit($defaultDesc, 160, '') }}">
    @if($seoKeywords)
    <meta name="keywords" content="{{ $seoKeywords }}">
    @endif
    <meta property="og:type" content="website">
    <meta property="og:title" content="{{ $seoOgTitle }}">
    <meta property="og:description" content="{{ $seoDescription ?? $defaultDescSh }}">
    @if($pageSeo && $pageSeo->og_image)
    <meta property="og:image" content="{{ $pageSeo->og_image }}">
    @endif
    <meta name="twitter:card" content="summary_large_image">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Amiri:wght@400;700&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: { DEFAULT: '#1a6b3c', dark: '#0f4a28', light: '#2d8f52', pale: '#e8f5ee' },
                        gold:  { DEFAULT: '#c9963c', light: '#e4b86a', pale: '#fdf6e8' },
                    }
                }
            }
        }
    </script>
    <style>
        body { font-family: 'Inter', sans-serif; }
        .arabic { font-family: 'Amiri', serif; direction: rtl; }
        .wave-bar {
            display: inline-block; width: 3px; border-radius: 2px;
            background: #1a6b3c; animation: wave 1.2s ease-in-out infinite;
        }
        .wave-bar:nth-child(1){animation-delay:0s}
        .wave-bar:nth-child(2){animation-delay:.15s;height:10px}
        .wave-bar:nth-child(3){animation-delay:.3s;height:18px}
        .wave-bar:nth-child(4){animation-delay:.45s;height:14px}
        .wave-bar:nth-child(5){animation-delay:.6s;height:8px}
        .wave-bar:nth-child(6){animation-delay:.75s;height:16px}
        .wave-bar:nth-child(7){animation-delay:.9s;height:12px}
        @keyframes wave {
            0%,100%{transform:scaleY(0.4);opacity:.6}
            50%{transform:scaleY(1);opacity:1}
        }
        .paused .wave-bar { animation-play-state: paused; }
        .prayer-active { background: #1a6b3c !important; color: #fff !important; }
        .ticker { animation: ticker 35s linear infinite; }
        @keyframes ticker { 0%{transform:translateX(100%)} 100%{transform:translateX(-100%)} }
        input[type=range]::-webkit-slider-thumb { background: #1a6b3c; }
        .nav-active { color: #1a6b3c; font-weight: 600; }
    </style>
    @yield('head')
</head>
<body class="bg-gray-50 text-gray-800">

{{-- ═══════════════════════════════════════════ HEADER ═══════════════════════════════════════════ --}}
<header class="bg-white border-b border-gray-100 sticky top-0 z-50 shadow-sm">
    <div class="max-w-6xl mx-auto px-4 py-3 flex items-center justify-between gap-3">

        {{-- Logo --}}
        <a href="{{ route('home') }}" class="flex items-center gap-2.5 shrink-0">
            <div class="w-9 h-9 bg-brand rounded-xl flex items-center justify-center">
                <i class="fa-solid fa-radio text-white text-sm"></i>
            </div>
            <div class="hidden sm:block leading-tight">
                <div class="font-bold text-brand text-base leading-none">Radyo Mevlana</div>
                <div class="text-xs text-gray-400">İslami Radyo</div>
            </div>
        </a>

        {{-- Mini Radio Player (desktop ortada) --}}
        <div class="flex-1 max-w-xs hidden md:flex items-center gap-2.5 bg-brand-pale rounded-xl px-3.5 py-2">
            <div id="hdr-wave" class="flex items-end gap-0.5 h-5 paused shrink-0">
                <span class="wave-bar" style="height:6px"></span>
                <span class="wave-bar" style="height:10px"></span>
                <span class="wave-bar" style="height:18px"></span>
                <span class="wave-bar" style="height:14px"></span>
                <span class="wave-bar" style="height:8px"></span>
                <span class="wave-bar" style="height:12px"></span>
                <span class="wave-bar" style="height:16px"></span>
            </div>
            <div class="flex-1 min-w-0">
                <div class="text-brand font-medium text-xs truncate" id="hdr-song">Şu an yayında...</div>
                <div class="text-gray-400 text-xs" id="hdr-listeners"></div>
            </div>
            <button onclick="togglePlay()"
                    class="w-7 h-7 rounded-full bg-brand hover:bg-brand-light text-white flex items-center justify-center transition shrink-0">
                <i id="hdr-play-icon" class="fa-solid fa-play text-xs ml-px"></i>
            </button>
        </div>

        {{-- Desktop Navigasyon --}}
        <nav class="hidden lg:flex items-center gap-1 text-sm text-gray-600">
            @foreach($headerNavItems as $item)
                @if($item->is_button)
                <a href="{{ $item->url }}" target="{{ $item->target }}"
                   class="bg-brand text-white px-3 py-1.5 rounded-lg hover:bg-brand-light transition text-xs font-medium flex items-center gap-1">
                    @if($item->icon)<i class="{{ $item->icon }}"></i>@endif
                    {{ $item->label }}
                </a>
                @else
                <a href="{{ $item->url }}" target="{{ $item->target }}"
                   class="px-2.5 py-1.5 rounded-lg hover:text-brand hover:bg-brand-pale transition flex items-center gap-1
                          {{ request()->is(ltrim($item->url, '/')) || (request()->is('/') && $item->url === '/') ? 'text-brand font-semibold' : '' }}">
                    @if($item->icon)<i class="{{ $item->icon }} text-xs"></i>@endif
                    {{ $item->label }}
                </a>
                @endif
            @endforeach
        </nav>

        {{-- Mobil: mini player toggle + hamburger --}}
        <div class="flex items-center gap-2 lg:hidden">
            <button onclick="togglePlay()"
                    class="w-8 h-8 rounded-full bg-brand text-white flex items-center justify-center md:hidden">
                <i id="hdr-play-icon-mobile" class="fa-solid fa-play text-xs ml-px"></i>
            </button>
            <button id="hamburger" onclick="toggleMobileMenu()"
                    class="p-2 text-gray-600 hover:text-brand transition">
                <i class="fa-solid fa-bars text-lg"></i>
            </button>
        </div>
    </div>

    {{-- Mobil Menü --}}
    <div id="mobile-menu" class="hidden lg:hidden border-t border-gray-100 bg-white">
        {{-- Mini player mobil --}}
        <div class="px-4 pt-3 pb-1">
            <div class="flex items-center gap-3 bg-brand-pale rounded-xl px-4 py-2.5">
                <div id="hdr-wave-m" class="flex items-end gap-0.5 h-5 paused shrink-0">
                    <span class="wave-bar" style="height:6px"></span>
                    <span class="wave-bar" style="height:10px"></span>
                    <span class="wave-bar" style="height:18px"></span>
                    <span class="wave-bar" style="height:14px"></span>
                    <span class="wave-bar" style="height:8px"></span>
                </div>
                <div class="flex-1 min-w-0">
                    <div class="text-brand font-medium text-sm truncate" id="hdr-song-m">Şu an yayında...</div>
                    <div class="text-gray-400 text-xs" id="hdr-listeners-m"></div>
                </div>
            </div>
        </div>
        {{-- Nav linkleri --}}
        <nav class="px-4 py-2 space-y-0.5">
            @foreach($headerNavItems as $item)
            <a href="{{ $item->url }}" target="{{ $item->target }}"
               class="flex items-center gap-2.5 px-3 py-2.5 rounded-xl text-sm transition
                      {{ $item->is_button
                         ? 'bg-brand text-white font-medium'
                         : 'text-gray-700 hover:bg-brand-pale hover:text-brand' }}">
                @if($item->icon)<i class="{{ $item->icon }} w-4 text-center text-xs"></i>@endif
                {{ $item->label }}
            </a>
            @endforeach
        </nav>
        <div class="px-4 pb-4"></div>
    </div>
</header>

{{-- Audio element (tüm sayfalarda kullanılabilsin) --}}
<audio id="radio-audio" preload="none"></audio>

{{-- Sayfa İçeriği --}}
@yield('content')

{{-- Banner: icerik_alti (tüm sayfalarda) --}}
@if(isset($banners) && $banners['icerik_alti']->isNotEmpty())
<div class="max-w-5xl mx-auto px-4 py-6 flex flex-wrap justify-center gap-4">
    @foreach($banners['icerik_alti'] as $banner)
    @if($banner->link_url)
    <a href="{{ $banner->link_url }}" target="{{ $banner->link_target }}" rel="noopener">
        <img src="{{ $banner->image_url }}" alt="{{ $banner->alt_text ?? $banner->name }}"
             class="max-h-24 rounded-xl object-contain">
    </a>
    @else
    <img src="{{ $banner->image_url }}" alt="{{ $banner->alt_text ?? $banner->name }}"
         class="max-h-24 rounded-xl object-contain">
    @endif
    @endforeach
</div>
@endif

{{-- ═══════════════════════════════════════════ FOOTER ════════════════════════════════════════════ --}}
<footer class="bg-brand-dark text-white py-10 mt-0">
    <div class="max-w-6xl mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 pb-8 border-b border-white/10">

            {{-- Marka --}}
            <div>
                <div class="flex items-center gap-2 mb-3">
                    <div class="w-8 h-8 bg-white/10 rounded-lg flex items-center justify-center">
                        <i class="fa-solid fa-radio text-gold text-sm"></i>
                    </div>
                    <span class="font-bold text-base">{{ $siteName ?? 'Radyo Mevlana' }}</span>
                </div>
                <p class="text-white/60 text-sm leading-relaxed">{{ $siteDescription ?? 'İslami içerikli 24 saat kesintisiz yayın.' }}</p>
            </div>

            {{-- Dinamik Footer Nav --}}
            <div>
                <h4 class="font-semibold mb-3 text-gold text-sm">Hızlı Bağlantılar</h4>
                @if($footerNavItems->isNotEmpty())
                <ul class="space-y-1.5 text-sm text-white/70">
                    @foreach($footerNavItems as $item)
                    <li>
                        <a href="{{ $item->url }}" target="{{ $item->target }}"
                           class="hover:text-white transition flex items-center gap-1.5">
                            @if($item->icon)<i class="{{ $item->icon }} text-xs w-4"></i>@endif
                            {{ $item->label }}
                        </a>
                    </li>
                    @endforeach
                </ul>
                @else
                <ul class="space-y-1.5 text-sm text-white/70">
                    <li><a href="{{ route('home') }}" class="hover:text-white transition">Ana Sayfa</a></li>
                    <li><a href="{{ route('hutbe.index') }}" class="hover:text-white transition">Hutbeler</a></li>
                    <li><a href="{{ route('announcements.index') }}" class="hover:text-white transition">Haberler</a></li>
                    <li><a href="{{ route('editor.index') }}" class="hover:text-white transition">Editör</a></li>
                </ul>
                @endif
            </div>

            {{-- İletişim --}}
            <div>
                <h4 class="font-semibold mb-3 text-gold text-sm">İletişim</h4>
                <p class="text-white/60 text-sm">{{ $siteContact ?? 'www.radyomevlana.com' }}</p>
                <div class="flex gap-3 mt-4">
                    <a href="{{ route('home') }}#istek"
                       class="inline-flex items-center gap-1.5 bg-brand text-white text-xs px-3 py-1.5 rounded-lg hover:bg-brand-light transition">
                        <i class="fa-solid fa-paper-plane"></i> Parça İste
                    </a>
                </div>
            </div>
        </div>

        <div class="pt-6 flex flex-col md:flex-row items-center justify-between gap-3">
            <p class="arabic text-gold text-xl">بِسْمِ اللَّهِ الرَّحْمَنِ الرَّحِيمِ</p>
            <p class="text-white/40 text-xs text-center">
                &copy; {{ date('Y') }} {{ $siteName ?? 'Radyo Mevlana' }}. Tüm hakları saklıdır.
            </p>
        </div>
    </div>
</footer>

{{-- ═══════════════════════════════════ CORE PLAYER JS ═══════════════════════════════════════════ --}}
<script>
const audio = document.getElementById('radio-audio');
const NOW_PLAYING_URL = '{{ url("/now-playing") }}';
let streamUrl = '{{ $shoutcastBase }}/stream';
let playing = false;

function togglePlay() {
    if (playing) {
        audio.pause();
        audio.src = '';
        setUi(false);
    } else {
        audio.src = streamUrl + '?t=' + Date.now();
        audio.play().catch(() => setUi(false));
        setUi(true);
    }
    playing = !playing;
}

function setUi(on) {
    const icons = ['hdr-play-icon', 'hdr-play-icon-mobile', 'play-icon'];
    icons.forEach(id => {
        const el = document.getElementById(id);
        if (!el) return;
        const extraClass = (id === 'play-icon') ? ' text-xl' : ' text-xs ml-px';
        el.className = 'fa-solid ' + (on ? 'fa-pause' : 'fa-play') + extraClass;
    });
    const label = document.getElementById('play-label');
    if (label) label.textContent = on ? 'Durdur' : 'Dinle';

    ['hdr-wave', 'hdr-wave-m', 'hero-wave'].forEach(id => {
        const el = document.getElementById(id);
        if (el) el.classList.toggle('paused', !on);
    });
}

audio.onerror = () => { playing = false; setUi(false); };

function updateNowPlaying() {
    fetch(NOW_PLAYING_URL).then(r => r.json()).then(data => {
        if (data.stream_url) streamUrl = data.stream_url;

        // Header mini player (her sayfada)
        ['hdr-song', 'hdr-song-m'].forEach(id => {
            const el = document.getElementById(id);
            if (el) el.textContent = data.current_song || '';
        });
        ['hdr-listeners', 'hdr-listeners-m'].forEach(id => {
            const el = document.getElementById(id);
            if (el) el.textContent = (data.listeners || 0) + ' dinleyici';
        });

        // Ana sayfa'ya özgü elementler (null-safe)
        const heroSong = document.getElementById('hero-song');
        if (heroSong) heroSong.textContent = data.current_song || '';

        const heroListeners = document.getElementById('hero-listeners');
        if (heroListeners) heroListeners.innerHTML =
            '<i class="fa-solid fa-headphones mr-1"></i>' + (data.listeners || 0) + ' dinleyici';

        const liveBadge = document.getElementById('live-badge');
        if (liveBadge) liveBadge.style.display = data.online ? 'flex' : 'none';

        if (data.history && data.history.length) {
            const historyList = document.getElementById('history-list');
            if (historyList) {
                historyList.innerHTML = data.history.map((s, i) => `
                    <div class="bg-white rounded-xl border border-gray-100 px-4 py-3 flex items-center gap-3 shadow-sm">
                        <span class="text-gray-300 font-bold text-sm w-5 text-center shrink-0">${i + 1}</span>
                        ${s.album_art
                            ? `<img src="${s.album_art}" alt="" class="w-10 h-10 rounded-lg object-cover shrink-0">`
                            : `<div class="w-10 h-10 rounded-lg bg-green-50 flex items-center justify-center shrink-0"><i class="fa-solid fa-music text-green-300 text-sm"></i></div>`}
                        <div class="min-w-0 flex-1">
                            <div class="font-medium text-gray-800 text-sm truncate">${s.title}</div>
                            ${s.artist ? `<div class="text-gray-400 text-xs truncate">${s.artist}</div>` : ''}
                        </div>
                        <div class="text-gray-300 text-xs shrink-0">${s.played_at}</div>
                    </div>`).join('');
            }

            const ticker = document.getElementById('ticker-text');
            if (ticker) ticker.textContent = data.history.map(s => s.title).join('  •  ');

            const art = data.history[0]?.album_art;
            const albumArt = document.getElementById('album-art');
            if (albumArt) { albumArt.src = art || ''; albumArt.classList.toggle('hidden', !art); }
            const artIcon = document.getElementById('art-icon');
            if (artIcon) artIcon.classList.toggle('hidden', !!art);
        }
    }).catch(() => {});
}

function toggleMobileMenu() {
    const menu = document.getElementById('mobile-menu');
    const icon = document.querySelector('#hamburger i');
    menu.classList.toggle('hidden');
    if (icon) icon.className = menu.classList.contains('hidden')
        ? 'fa-solid fa-bars text-lg'
        : 'fa-solid fa-xmark text-lg';
}

// Sayfa yüklenince mevcut bilgiyi çek
updateNowPlaying();
setInterval(updateNowPlaying, 30000);
</script>

@yield('scripts')
</body>
</html>
