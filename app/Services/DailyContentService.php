<?php

namespace App\Services;

use App\Models\DailyContent;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class DailyContentService
{
    public function fetchAyet(): ?DailyContent
    {
        $today = today()->toDateString();
        $existing = DailyContent::where('type', 'ayet')->where('date', $today)->where('is_manual', false)->first();
        if ($existing) {
            return $existing;
        }

        try {
            // Günün ayet numarası (1–6236 arası, gün bazlı döngü)
            $num = (today()->dayOfYear * 17 % 6236) + 1;

            // Türkçe metin — path-based edition
            $trRes = Http::timeout(10)->get("https://api.alquran.cloud/v1/ayah/{$num}/tr.diyanet");

            if (!$trRes->successful()) {
                return null;
            }

            $tr = $trRes->json('data');

            if (empty($tr['text'])) {
                return null;
            }

            // Arapça metin
            $arText = null;
            $arRes  = Http::timeout(10)->get("https://api.alquran.cloud/v1/ayah/{$num}/quran-uthmani");
            if ($arRes->successful()) {
                $arText = $arRes->json('data.text');
            }

            $surah  = $tr['surah']['name'] ?? '';
            $ayahNo = $tr['numberInSurah'] ?? '';
            $source = $surah ? "{$surah} Suresi, {$ayahNo}. Ayet" : '';

            return DailyContent::create([
                'type'       => 'ayet',
                'title'      => 'Günün Ayeti',
                'content_ar' => $arText,
                'content_tr' => $tr['text'],
                'source'     => $source,
                'date'       => $today,
                'is_manual'  => false,
                'is_published' => true,
            ]);
        } catch (\Exception $e) {
            Log::warning('Ayet fetch error: ' . $e->getMessage());
            return null;
        }
    }

    public function fetchHadis(): ?DailyContent
    {
        $today = today()->toDateString();
        $existing = DailyContent::where('type', 'hadis')->where('date', $today)->where('is_manual', false)->first();
        if ($existing) {
            return $existing;
        }

        try {
            $hadisNo  = (today()->dayOfYear % 42) + 1;
            $response = Http::timeout(10)
                ->get("https://cdn.jsdelivr.net/gh/fawazahmed0/hadith-api@latest/editions/tur-nawawi/{$hadisNo}.json");

            if (!$response->successful()) {
                return null;
            }

            $data   = $response->json();
            // API anahtarı "hadiths" (çoğul)
            $hadiths = $data['hadiths'] ?? [];
            $hadis   = $hadiths[0] ?? null;

            if (!$hadis || empty($hadis['text'])) {
                return null;
            }

            return DailyContent::create([
                'type'       => 'hadis',
                'title'      => 'Günün Hadisi',
                'content_ar' => null,
                'content_tr' => $hadis['text'],
                'source'     => "Kırk Hadis, {$hadisNo}. Hadis",
                'date'       => $today,
                'is_manual'  => false,
                'is_published' => true,
            ]);
        } catch (\Exception $e) {
            Log::warning('Hadis fetch error: ' . $e->getMessage());
            return null;
        }
    }

    public function getToday(): array
    {
        return [
            'ayet'  => DailyContent::todayOf('ayet')  ?? $this->fetchAyet(),
            'hadis' => DailyContent::todayOf('hadis') ?? $this->fetchHadis(),
            'soz'   => DailyContent::todayOf('soz'),
        ];
    }

    public function getRotatedAyet(int $slot, int $intervalHours = 6): ?object
    {
        return \Illuminate\Support\Facades\Cache::remember("ayet_rot_{$slot}", $intervalHours * 3600, function () use ($slot) {
            $ayetNum = ($slot * 17 % 6236) + 1;

            $trRes = Http::timeout(10)->get("https://api.alquran.cloud/v1/ayah/{$ayetNum}/tr.diyanet");
            if (!$trRes->successful()) {
                return DailyContent::where('type', 'ayet')->latest('date')->first();
            }

            $tr = $trRes->json('data');
            if (empty($tr['text'])) {
                return DailyContent::where('type', 'ayet')->latest('date')->first();
            }

            $arText = null;
            $arRes  = Http::timeout(10)->get("https://api.alquran.cloud/v1/ayah/{$ayetNum}/quran-uthmani");
            if ($arRes->successful()) {
                $arText = $arRes->json('data.text');
            }

            $surah  = $tr['surah']['name'] ?? '';
            $ayahNo = $tr['numberInSurah'] ?? '';

            return (object) [
                'content_ar' => $arText,
                'content_tr' => $tr['text'],
                'source'     => $surah ? "{$surah} Suresi, {$ayahNo}. Ayet" : '',
            ];
        });
    }

    public function getRotatedHadis(int $slot, int $intervalHours = 6): ?object
    {
        return \Illuminate\Support\Facades\Cache::remember("hadis_rot_{$slot}", $intervalHours * 3600, function () use ($slot) {
            $hadisNo  = ($slot % 42) + 1;
            $response = Http::timeout(10)
                ->get("https://cdn.jsdelivr.net/gh/fawazahmed0/hadith-api@latest/editions/tur-nawawi/{$hadisNo}.json");

            if (!$response->successful()) {
                return DailyContent::where('type', 'hadis')->latest('date')->first();
            }

            $hadiths = $response->json('hadiths') ?? [];
            $hadis   = $hadiths[0] ?? null;

            if (!$hadis || empty($hadis['text'])) {
                return DailyContent::where('type', 'hadis')->latest('date')->first();
            }

            return (object) [
                'content_ar' => null,
                'content_tr' => $hadis['text'],
                'source'     => "Kırk Hadis, {$hadisNo}. Hadis",
            ];
        });
    }
}
