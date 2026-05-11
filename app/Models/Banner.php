<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Banner extends Model
{
    protected $fillable = [
        'name', 'location', 'image_url', 'link_url', 'link_target',
        'alt_text', 'is_active', 'sort_order', 'starts_at', 'ends_at',
    ];

    protected $casts = [
        'is_active'  => 'boolean',
        'starts_at'  => 'datetime',
        'ends_at'    => 'datetime',
    ];

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true)
            ->where(fn ($q) => $q->whereNull('starts_at')->orWhere('starts_at', '<=', now()))
            ->where(fn ($q) => $q->whereNull('ends_at')->orWhere('ends_at', '>=', now()));
    }

    public static function forLocation(string $location): \Illuminate\Support\Collection
    {
        return Cache::remember("banners_{$location}", 300, fn () =>
            static::active()
                ->where('location', $location)
                ->orderBy('sort_order')
                ->get()
        );
    }

    public static function locations(): array
    {
        return [
            'anasayfa'    => 'Ana Sayfa (radyo bölümü altı)',
            'icerik_alti' => 'İçerik Altı (tüm sayfalarda)',
            'hutbeler'    => 'Hutbeler Sayfası',
            'duyurular'   => 'Duyurular Sayfası',
        ];
    }
}
