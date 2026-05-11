<?php

namespace App\Console\Commands;

use App\Services\DailyContentService;
use App\Services\PrayerTimeService;
use Illuminate\Console\Command;

class FetchDailyData extends Command
{
    protected $signature   = 'daily:fetch';
    protected $description = 'Günlük ezan vakitleri, ayet ve hadis verilerini çeker';

    public function handle(PrayerTimeService $prayer, DailyContentService $content): void
    {
        $prayer->fetchAndStore();
        $content->fetchAyet();
        $content->fetchHadis();
        $this->info('Günlük veriler güncellendi.');
    }
}
