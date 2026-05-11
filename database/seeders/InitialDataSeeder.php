<?php

namespace Database\Seeders;

use App\Models\AdminUser;
use App\Models\NavItem;
use App\Models\PageSeo;
use Illuminate\Database\Seeder;

class InitialDataSeeder extends Seeder
{
    public function run(): void
    {
        // ── Admin Kullanıcısı ────────────────────────────────
        if (!AdminUser::where('username', 'admin')->exists()) {
            AdminUser::create([
                'name'      => 'Mehmet Uzunca',
                'username'  => 'admin',
                'password'  => 'mevlana2026',
                'is_active' => true,
            ]);
        }

        // ── Header Nav Öğeleri ──────────────────────────────
        $headerItems = [
            ['label' => 'Hutbeler',  'url' => '/hutbeler',    'location' => 'header', 'sort_order' => 10],
            ['label' => 'Haberler',  'url' => '/duyurular',   'location' => 'header', 'sort_order' => 20],
            ['label' => 'Editör',    'url' => '/editor',      'location' => 'header', 'sort_order' => 30],
            ['label' => 'Ezan',      'url' => '/#ezan',       'location' => 'header', 'sort_order' => 40],
            ['label' => 'Parça İste','url' => '/#istek',      'location' => 'header', 'sort_order' => 50, 'is_button' => true],
        ];

        foreach ($headerItems as $item) {
            NavItem::firstOrCreate(
                ['url' => $item['url'], 'location' => $item['location']],
                array_merge(['target' => '_self', 'is_active' => true, 'is_button' => false], $item)
            );
        }

        // ── Footer Nav Öğeleri ──────────────────────────────
        $footerItems = [
            ['label' => 'Ana Sayfa',     'url' => '/',            'location' => 'footer', 'sort_order' => 10],
            ['label' => 'Hutbeler',      'url' => '/hutbeler',    'location' => 'footer', 'sort_order' => 20],
            ['label' => 'Haberler',      'url' => '/duyurular',   'location' => 'footer', 'sort_order' => 30],
            ['label' => 'Editör',        'url' => '/editor',      'location' => 'footer', 'sort_order' => 40],
            ['label' => 'Ezan Vakitleri','url' => '/#ezan',       'location' => 'footer', 'sort_order' => 50],
        ];

        foreach ($footerItems as $item) {
            NavItem::firstOrCreate(
                ['url' => $item['url'], 'location' => $item['location']],
                array_merge(['target' => '_self', 'is_active' => true, 'is_button' => false], $item)
            );
        }

        // ── SEO: Ana sayfalar ────────────────────────────────
        $seoPages = [
            [
                'path'        => '/',
                'title'       => 'Radyo Mevlana – İslami Radyo | 24 Saat Kesintisiz Yayın',
                'description' => 'Radyo Mevlana ile 24 saat kesintisiz İslami müzik dinleyin. KKTC ezan vakitleri, günün ayeti, hadisi ve daha fazlası.',
                'keywords'    => 'radyo mevlana, islami radyo, kktc ezan vakitleri, günün ayeti, online radio',
            ],
            [
                'path'        => '/hutbeler',
                'title'       => 'Hutbeler – Radyo Mevlana',
                'description' => 'KKTC Din İşleri Başkanlığı hutbe arşivi. PDF ve Word formatında hutbe indirebilirsiniz.',
                'keywords'    => 'hutbe, kktc hutbe, cuma hutbesi, pdf hutbe indir',
            ],
            [
                'path'        => '/duyurular',
                'title'       => 'Haberler & Duyurular – Radyo Mevlana',
                'description' => 'KKTC Din İşleri Başkanlığı ve Evkaf\'tan güncel haberler ve duyurular.',
                'keywords'    => 'kktc din isleri, evkaf, duyurular, haberler',
            ],
            [
                'path'        => '/editor',
                'title'       => 'Editör Köşesi – Radyo Mevlana',
                'description' => 'Tasavvuf ve manevi düşünceler. Kalbi arayanlar için kelimeler.',
                'keywords'    => 'tasavvuf, manevi yazılar, editör köşesi, islami düşünceler',
            ],
        ];

        foreach ($seoPages as $seo) {
            PageSeo::firstOrCreate(['path' => $seo['path']], $seo);
        }
    }
}
