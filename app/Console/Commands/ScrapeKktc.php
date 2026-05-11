<?php

namespace App\Console\Commands;

use App\Services\KktcScraperService;
use Illuminate\Console\Command;

class ScrapeKktc extends Command
{
    protected $signature   = 'kktc:scrape {--full : Tüm hutbeleri çek (varsayılan: son 20)}';
    protected $description = 'KKTC Din İşleri\'nden hutbe ve duyuruları çeker';

    public function handle(KktcScraperService $service): void
    {
        $limit = $this->option('full') ? 300 : 20;

        $this->info("Hutbeler çekiliyor (limit: {$limit})...");
        $hutbeSaved = $service->syncHutbes($limit);
        $this->info("→ {$hutbeSaved} yeni hutbe kaydedildi.");

        $this->info('Duyurular çekiliyor...');
        $duyuruSaved = $service->syncDuyurular();
        $this->info("→ {$duyuruSaved} yeni duyuru kaydedildi.");
    }
}
