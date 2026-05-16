<?php

namespace App\Console\Commands;

use App\Services\ShoutcastService;
use Illuminate\Console\Command;

class ImportSongHistory extends Command
{
    protected $signature   = 'shoutcast:import-history {--limit=20 : Kaç parça içe aktarılsın}';
    protected $description = 'Shoutcast sunucusundan son çalınan parçaları veritabanına aktarır';

    public function handle(ShoutcastService $service): void
    {
        $limit    = (int) $this->option('limit');
        $this->info("Shoutcast geçmişi çekiliyor (limit: {$limit})...");
        $imported = $service->importHistory($limit);
        $this->info("Tamamlandı: {$imported} yeni parça eklendi.");
    }
}
