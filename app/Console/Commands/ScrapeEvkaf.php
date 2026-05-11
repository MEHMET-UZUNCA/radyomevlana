<?php

namespace App\Console\Commands;

use App\Services\EvkafScraperService;
use Illuminate\Console\Command;

class ScrapeEvkaf extends Command
{
    protected $signature   = 'evkaf:scrape {--pages=2 : Kaç sayfa çekilsin}';
    protected $description = 'Evkaf.org\'dan haberler ve duyuruları çeker';

    public function handle(EvkafScraperService $service): void
    {
        $pages = (int) $this->option('pages');

        $this->info("Evkaf haberler çekiliyor ({$pages} sayfa)...");
        $h = $service->syncHaberler($pages);
        $this->info("→ {$h} yeni haber kaydedildi.");

        $this->info("Evkaf duyurular çekiliyor ({$pages} sayfa)...");
        $d = $service->syncDuyurular($pages);
        $this->info("→ {$d} yeni duyuru kaydedildi.");
    }
}
