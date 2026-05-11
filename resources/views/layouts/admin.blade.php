<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin') – Radyo Mevlana</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = { theme: { extend: { colors: {
            brand:{ DEFAULT:'#1a6b3c', dark:'#0f4a28', light:'#2d8f52' },
            gold:{ DEFAULT:'#c9963c' }
        }}}}
    </script>
</head>
<body class="bg-gray-100 text-gray-800 min-h-screen flex">

{{-- Sidebar --}}
<aside class="w-56 bg-brand-dark text-white flex flex-col shrink-0 fixed h-full z-40">
    <div class="px-5 py-4 border-b border-white/10">
        <div class="flex items-center gap-2">
            <i class="fa-solid fa-radio text-gold"></i>
            <div>
                <div class="font-bold text-sm">Radyo Mevlana</div>
                <div class="text-white/40 text-xs">Admin Panel</div>
            </div>
        </div>
    </div>

    <nav class="flex-1 py-3 overflow-y-auto">
        @php
        $nav = [
            ['admin.dashboard',            'fa-gauge-high',          'Dashboard'],
            ['admin.requests.index',       'fa-music',               'İstekler'],
            ['admin.history.index',        'fa-clock-rotate-left',   'Parça Geçmişi'],
            ['admin.hutbe.index',          'fa-scroll',              'Hutbeler'],
            ['admin.announcements.index',  'fa-bullhorn',            'Duyurular'],
            ['admin.editor.index',         'fa-feather-pointed',     'Editör'],
            ['admin.prayer-times.index',   'fa-mosque',              'Ezan Vakitleri'],
            ['admin.daily-content.index',  'fa-book-open',           'Günlük İçerik'],
            null, // separator
            ['admin.nav.index',            'fa-bars',                'Menü Yönetimi'],
            ['admin.pages.index',          'fa-file-lines',          'Sayfalar'],
            ['admin.banners.index',        'fa-rectangle-ad',        'Bannerlar'],
            ['admin.seo.index',            'fa-magnifying-glass',    'SEO Ayarları'],
            ['admin.users.index',          'fa-users',               'Yöneticiler'],
            ['admin.settings.index',       'fa-gear',                'Ayarlar'],
        ];
        $pending = \App\Models\SongRequest::where('status','pending')->count();
        @endphp

        @foreach($nav as $item)
        @if($item === null)
        <div class="my-1.5 border-t border-white/10 mx-3"></div>
        @else
        @php [$route, $icon, $label] = $item; @endphp
        <a href="{{ route($route) }}"
           class="flex items-center gap-3 px-4 py-2.5 text-sm transition {{ request()->routeIs(str_replace('.index','',$route).'*') ? 'bg-brand text-white' : 'text-white/60 hover:text-white hover:bg-white/5' }}">
            <i class="fa-solid {{ $icon }} w-4 text-sm"></i>
            <span>{{ $label }}</span>
            @if($route === 'admin.requests.index' && $pending > 0)
            <span class="ml-auto bg-amber-500 text-white text-xs font-bold px-1.5 py-0.5 rounded-full">{{ $pending }}</span>
            @endif
        </a>
        @endif
        @endforeach
    </nav>

    <div class="px-3 py-3 border-t border-white/10 space-y-1">
        <a href="{{ route('home') }}" target="_blank"
           class="flex items-center gap-2 px-3 py-2 text-white/50 hover:text-white text-xs transition">
            <i class="fa-solid fa-arrow-up-right-from-square"></i> Siteyi Gör
        </a>
        <form action="{{ route('admin.logout') }}" method="POST">
            @csrf
            <button class="w-full flex items-center gap-2 px-3 py-2 text-white/50 hover:text-red-400 text-xs transition text-left">
                <i class="fa-solid fa-right-from-bracket"></i> Çıkış Yap
            </button>
        </form>
    </div>
</aside>

{{-- Content --}}
<div class="flex-1 ml-56 flex flex-col min-h-screen">
    <header class="bg-white border-b border-gray-200 px-6 py-3.5 flex items-center justify-between sticky top-0 z-30">
        <h1 class="font-semibold text-gray-700">@yield('title', 'Dashboard')</h1>
        <span class="text-xs text-gray-400">{{ now()->format('d.m.Y H:i') }}</span>
    </header>

    <main class="flex-1 p-6">
        @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 rounded-lg px-4 py-3 mb-5 flex items-center gap-2 text-sm">
            <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
        </div>
        @endif
        @if(session('error'))
        <div class="bg-red-50 border border-red-200 text-red-700 rounded-lg px-4 py-3 mb-5 flex items-center gap-2 text-sm">
            <i class="fa-solid fa-circle-xmark"></i> {{ session('error') }}
        </div>
        @endif

        @yield('content')
    </main>
</div>

</body>
</html>
