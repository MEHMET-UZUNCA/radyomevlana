<?php

namespace App\Services;

use App\Models\PrayerTime;
use App\Models\Setting;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PrayerTimeService
{
    public function fetchAndStore(\DateTimeInterface|string $date = null): ?PrayerTime
    {
        $dateStr = $date ? (is_string($date) ? $date : $date->format('Y-m-d')) : today()->toDateString();

        $existing = PrayerTime::where('date', $dateStr)->first();
        if ($existing) {
            return $existing;
        }

        $city    = Setting::get('prayer_city', 'Lefkosa');
        $country = Setting::get('prayer_country', 'Cyprus');
        $method  = Setting::get('prayer_method', '13');

        try {
            $response = Http::timeout(10)->get('https://api.aladhan.com/v1/timingsByCity', [
                'city'    => $city,
                'country' => $country,
                'method'  => $method,
                'date'    => $dateStr,
            ]);

            if ($response->successful()) {
                $timings = $response->json('data.timings');

                return PrayerTime::create([
                    'date'    => $dateStr,
                    'imsak'   => substr($timings['Imsak'] ?? '00:00', 0, 5),
                    'fajr'    => substr($timings['Fajr'] ?? '00:00', 0, 5),
                    'sunrise' => substr($timings['Sunrise'] ?? '00:00', 0, 5),
                    'dhuhr'   => substr($timings['Dhuhr'] ?? '00:00', 0, 5),
                    'asr'     => substr($timings['Asr'] ?? '00:00', 0, 5),
                    'maghrib' => substr($timings['Maghrib'] ?? '00:00', 0, 5),
                    'isha'    => substr($timings['Isha'] ?? '00:00', 0, 5),
                ]);
            }
        } catch (\Exception $e) {
            Log::warning('Prayer time fetch error: ' . $e->getMessage());
        }

        return null;
    }

    public function today(): ?PrayerTime
    {
        return PrayerTime::today() ?? $this->fetchAndStore();
    }

    public function nextPrayer(PrayerTime $pt): array
    {
        $now = now()->format('H:i');
        $prayers = [
            'İmsak'   => $pt->imsak,
            'Sabah'   => $pt->fajr,
            'Güneş'   => $pt->sunrise,
            'Öğle'    => $pt->dhuhr,
            'İkindi'  => $pt->asr,
            'Akşam'   => $pt->maghrib,
            'Yatsı'   => $pt->isha,
        ];

        foreach ($prayers as $name => $time) {
            if ($time > $now) {
                return ['name' => $name, 'time' => $time];
            }
        }

        return ['name' => 'İmsak', 'time' => $pt->imsak];
    }
}
