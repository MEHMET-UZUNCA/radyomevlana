<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\NavItem;
use App\Models\PageSeo;

return new class extends Migration
{
    public function up(): void
    {
        // İletişim linki header nav'a ekle
        NavItem::firstOrCreate(
            ['url' => '/iletisim', 'location' => 'header'],
            [
                'label'      => 'İletişim',
                'target'     => '_self',
                'icon'       => 'fa-solid fa-envelope',
                'sort_order' => 90,
                'is_active'  => true,
                'is_button'  => false,
            ]
        );

        // İletişim linki footer'a ekle
        NavItem::firstOrCreate(
            ['url' => '/iletisim', 'location' => 'footer'],
            [
                'label'      => 'İletişim',
                'target'     => '_self',
                'icon'       => 'fa-solid fa-envelope',
                'sort_order' => 90,
                'is_active'  => true,
                'is_button'  => false,
            ]
        );

        // İletişim sayfası SEO
        PageSeo::firstOrCreate(
            ['path' => '/iletisim'],
            [
                'title'       => 'İletişim – Radyo Mevlana',
                'description' => 'Radyo Mevlana ile iletişime geçin. Görüş ve önerilerinizi bizimle paylaşın.',
                'keywords'    => 'radyo mevlana iletişim, islami radyo, mehmet uzunca',
            ]
        );
    }

    public function down(): void
    {
        NavItem::where('url', '/iletisim')->delete();
        PageSeo::where('path', '/iletisim')->delete();
    }
};
