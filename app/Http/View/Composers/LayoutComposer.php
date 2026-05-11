<?php

namespace App\Http\View\Composers;

use App\Models\Banner;
use App\Models\NavItem;
use App\Models\PageSeo;
use App\Models\Setting;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class LayoutComposer
{
    public function compose(View $view): void
    {
        $view->with([
            'headerNavItems' => Cache::remember('nav_header', 300, fn () =>
                NavItem::where('is_active', true)
                    ->whereIn('location', ['header', 'both'])
                    ->orderBy('sort_order')
                    ->get()
            ),
            'footerNavItems' => Cache::remember('nav_footer', 300, fn () =>
                NavItem::where('is_active', true)
                    ->whereIn('location', ['footer', 'both'])
                    ->orderBy('sort_order')
                    ->get()
            ),
            'pageSeo'         => PageSeo::forPath(self::currentPath()),
            'shoutcastBase'   => rtrim(Setting::get('shoutcast_url', 'https://radyo.radyomevlana.com:9786'), '/'),
            'siteName'        => Setting::get('site_name', 'Radyo Mevlana'),
            'siteContact'     => Setting::get('site_contact', 'www.radyomevlana.com'),
            'siteDescription' => Setting::get('site_description', 'İslami içerikli 24 saat kesintisiz yayın. Gönlünüzün sesi.'),
            'banners'         => collect(array_keys(Banner::locations()))
                ->mapWithKeys(fn ($loc) => [$loc => Banner::forLocation($loc)]),
        ]);
    }

    private static function currentPath(): string
    {
        $path = request()->path();
        return $path === '' ? '/' : '/' . $path;
    }
}
