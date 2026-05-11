<?php

namespace App\Console\Commands;

use App\Models\Hutbe;
use App\Services\KktcScraperService;
use Illuminate\Console\Command;

class FillHutbeContent extends Command
{
    protected $signature   = 'hutbe:fill-content {--limit=10 : Kaç hutbe işlensin}';
    protected $description = 'PDF\'ten hutbe metni çıkarır (içeriği boş olanlar için)';

    public function handle(KktcScraperService $service): void
    {
        if (!$service->pdfToTextAvailable()) {
            $this->error('pdftotext komutu sunucuda bulunamadı. poppler-utils kurulumu gerekiyor.');
            return;
        }

        $hutbes = Hutbe::whereNull('content')
            ->whereNotNull('pdf_url')
            ->latest('date')
            ->limit((int) $this->option('limit'))
            ->get();

        if ($hutbes->isEmpty()) {
            $this->info('İşlenecek hutbe bulunamadı.');
            return;
        }

        $this->info("İşlenecek hutbe: {$hutbes->count()}");
        $filled = 0;

        foreach ($hutbes as $hutbe) {
            $this->line("  → [{$hutbe->source_id}] {$hutbe->title}");
            $content = $service->extractPdfContent($hutbe->pdf_url);
            if ($content) {
                $hutbe->update(['content' => $content]);
                $filled++;
                $this->info("    ✓ İçerik eklendi (" . mb_strlen($content) . " karakter)");
            } else {
                $this->warn("    ✗ İçerik çıkarılamadı");
            }
            usleep(500000);
        }

        $this->info("Tamamlandı: {$filled}/{$hutbes->count()} hutbeye içerik eklendi.");
    }
}
