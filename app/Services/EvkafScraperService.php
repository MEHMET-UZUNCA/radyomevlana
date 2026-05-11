<?php

namespace App\Services;

use App\Models\Announcement;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class EvkafScraperService
{
    private const BASE = 'https://evkaf.org';

    public function syncHaberler(int $pages = 2): int
    {
        $saved = 0;
        for ($page = 1; $page <= $pages; $page++) {
            $saved += $this->scrapePage('/haberler', 'duyuru', 'haber-', $page);
        }
        return $saved;
    }

    public function syncDuyurular(int $pages = 2): int
    {
        $saved = 0;
        for ($page = 1; $page <= $pages; $page++) {
            $saved += $this->scrapePage('/duyurular', 'duyuru', 'duyuru-', $page);
        }
        return $saved;
    }

    private function scrapePage(string $path, string $category, string $prefix, int $page): int
    {
        try {
            $url = self::BASE . $path . ($page > 1 ? "?page={$page}" : '');
            $res = Http::timeout(15)
                ->withHeaders(['User-Agent' => 'Mozilla/5.0 (compatible; RadyoMevlana/1.0)'])
                ->get($url);

            if (!$res->successful()) {
                return 0;
            }

            $html  = $res->body();
            $saved = 0;

            // Evkaf uses relative URLs without leading slash: href="haber-slug-name"
            preg_match_all(
                '/href="(' . preg_quote($prefix, '/') . '[a-z0-9\-]+)"[^>]*>([^<]{5,200})<\/a/i',
                $html,
                $matches,
                PREG_SET_ORDER
            );

            // Tarihleri de çek
            preg_match_all('/(\d{2}\.\d{2}\.\d{4})/', $html, $dateMatches);
            $dates = $dateMatches[1] ?? [];

            foreach ($matches as $i => $m) {
                $slug  = $m[1];
                $title = trim(html_entity_decode(strip_tags($m[2]), ENT_QUOTES, 'UTF-8'));

                if (strlen($title) < 5) {
                    continue;
                }

                $extId = 'evkaf_' . $slug;
                if (Announcement::where('external_id', $extId)->exists()) {
                    continue;
                }

                // Tarih parse
                $pubDate = null;
                if (!empty($dates[$i])) {
                    $parts   = explode('.', $dates[$i]);
                    $pubDate = "{$parts[2]}-{$parts[1]}-{$parts[0]}";
                }

                // Detay sayfasından excerpt çek
                $excerpt = $this->fetchExcerpt(self::BASE . '/' . $slug);

                Announcement::create([
                    'category'    => $category,
                    'source'      => 'evkaf',
                    'external_id' => $extId,
                    'title'       => $title,
                    'excerpt'     => $excerpt,
                    'source_url'  => self::BASE . '/' . $slug,
                    'published_at' => $pubDate,
                    'is_published' => true,
                ]);

                $saved++;
                usleep(200000);
            }

            return $saved;
        } catch (\Exception $e) {
            Log::warning("Evkaf {$path} page {$page} error: " . $e->getMessage());
            return 0;
        }
    }

    private function fetchExcerpt(string $url): ?string
    {
        try {
            $res = Http::timeout(10)
                ->withHeaders(['User-Agent' => 'Mozilla/5.0 (compatible; RadyoMevlana/1.0)'])
                ->get($url);

            if (!$res->successful()) {
                return null;
            }

            preg_match_all('/<p[^>]*>(.+?)<\/p>/is', $res->body(), $m);
            $paragraphs = array_filter(array_map(
                fn($p) => trim(html_entity_decode(strip_tags($p), ENT_QUOTES | ENT_HTML5, 'UTF-8')),
                $m[1] ?? []
            ), fn($p) => strlen($p) > 30);

            return mb_substr(implode(' ', array_slice($paragraphs, 0, 2)), 0, 400) ?: null;
        } catch (\Exception $e) {
            return null;
        }
    }
}
