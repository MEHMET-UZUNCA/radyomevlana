<?php

namespace App\Services;

use App\Models\Announcement;
use App\Models\Hutbe;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class KktcScraperService
{
    private const BASE = 'https://www.kktcdinisleri.com';

    private function toUtf8(string $html): string
    {
        // HTML meta charset'ten kodlamayı tespit et ve UTF-8'e çevir
        if (preg_match('/charset=["\']?([a-zA-Z0-9_\-]+)/i', $html, $m)) {
            $charset = strtoupper(trim($m[1]));
            if ($charset !== 'UTF-8' && $charset !== 'UTF8') {
                $converted = mb_convert_encoding($html, 'UTF-8', $charset);
                return $converted ?: $html;
            }
        }
        return $html;
    }

    // ── Hutbeler ──────────────────────────────────────────

    public function scrapeHutbeList(): array
    {
        try {
            $res = Http::timeout(15)
                ->withHeaders(['User-Agent' => 'Mozilla/5.0 (compatible; RadyoMevlana/1.0)'])
                ->get(self::BASE . '/hutbe.php');

            if (!$res->successful()) {
                return [];
            }

            $html = $this->toUtf8($res->body());
            $items = [];
            $seen  = [];

            // Format 1: Haftanın hutbesi — class="hutbebaslik" (çift tırnak)
            preg_match_all(
                '/href="hutbedetay\.php\?id=(\d+)"[^>]*class="hutbebaslik">\s*([^<\n]+)\s*<br>.*?class="hutbetarih">\s*([\d\.]+)\s*<\/p>/is',
                $html,
                $m1,
                PREG_SET_ORDER
            );
            foreach ($m1 as $m) {
                $id = (int) $m[1];
                if (!isset($seen[$id])) {
                    $seen[$id] = true;
                    $items[] = [
                        'id'    => $id,
                        'title' => trim(html_entity_decode(strip_tags($m[2]), ENT_QUOTES, 'UTF-8')),
                        'date'  => trim($m[3]),
                    ];
                }
            }

            // Format 2: Arşiv — class='baslik' (tek tırnak) + class='tarih' + optional download link
            // <p class='tarih'>30.04.2026</p><a ... href='hutbedetay.php?id=283'>Başlık</a><a ... class='indira' href='hutbeler/XXXX.docx'>
            preg_match_all(
                "/<p class='tarih'>([\d\.]+)<\/p>\s*<a[^>]*href='hutbedetay\.php\?id=(\d+)'[^>]*>([^<]+)<\/a>(?:\s*<a[^>]*class='indira'[^>]*href='([^']+)'[^>]*>)?/i",
                $html,
                $m2,
                PREG_SET_ORDER
            );
            foreach ($m2 as $m) {
                $id = (int) $m[2];
                if (!isset($seen[$id])) {
                    $seen[$id] = true;
                    $fileHref = isset($m[4]) ? trim($m[4]) : null;
                    $fileUrl  = $fileHref ? self::BASE . '/' . ltrim($fileHref, '/') : null;
                    // Determine if Word or PDF by extension
                    $wordUrl = null;
                    $pdfUrl  = null;
                    if ($fileUrl) {
                        $lower = strtolower($fileUrl);
                        if (str_contains($lower, '.pdf')) {
                            $pdfUrl = $fileUrl;
                        } else {
                            $wordUrl = $fileUrl;
                        }
                    }
                    $items[] = [
                        'id'       => $id,
                        'title'    => trim(html_entity_decode(strip_tags($m[3]), ENT_QUOTES, 'UTF-8')),
                        'date'     => trim($m[1]),
                        'pdf_url'  => $pdfUrl,
                        'word_url' => $wordUrl,
                    ];
                }
            }

            // Tarihe göre yeniden sırala (en yeni önce)
            usort($items, fn($a, $b) => $b['id'] <=> $a['id']);

            return $items;
        } catch (\Exception $e) {
            Log::warning('KKTC hutbe list scrape error: ' . $e->getMessage());
            return [];
        }
    }

    private function isLoginPage(string $html): bool
    {
        return str_contains($html, 'SP no') || str_contains($html, 'Bağlantınız başarılı');
    }

    public function scrapeHutbeDetail(int $id): ?array
    {
        try {
            $res = Http::timeout(15)
                ->withHeaders(['User-Agent' => 'Mozilla/5.0 (compatible; RadyoMevlana/1.0)'])
                ->get(self::BASE . '/hutbedetay.php', ['id' => $id]);

            if (!$res->successful()) {
                return null;
            }

            $html = $res->body();

            // KKTC detail pages require login — return no content if login page returned
            if ($this->isLoginPage($html)) {
                return ['title' => null, 'date' => null, 'pdf_url' => null, 'word_url' => null, 'content' => null];
            }

            // Başlık
            preg_match('/<title[^>]*>([^<]+)<\/title>/i', $html, $titleMatch);
            $title = trim(html_entity_decode($titleMatch[1] ?? '', ENT_QUOTES, 'UTF-8'));

            // Tarih
            preg_match('/(\d{2}\.\d{2}\.\d{4})/', $html, $dateMatch);
            $date = null;
            if (!empty($dateMatch[1])) {
                $parts = explode('.', $dateMatch[1]);
                $date  = "{$parts[2]}-{$parts[1]}-{$parts[0]}";
            }

            // PDF linki — hutbeler/XXXX.pdf
            preg_match('/href="(hutbeler\/[^"]+\.pdf)"/i', $html, $pdfMatch);
            $pdfUrl  = !empty($pdfMatch[1]) ? self::BASE . '/' . $pdfMatch[1] : null;

            // Word linki — hutbeler/XXXX.docx veya .doc
            preg_match('/href="(hutbeler\/[^"]+\.doc(?:x)?)"/i', $html, $wordMatch);
            $wordUrl = !empty($wordMatch[1]) ? self::BASE . '/' . $wordMatch[1] : null;

            // İçerik — <p> blokları
            preg_match_all('/<p[^>]*>(.+?)<\/p>/is', $html, $pMatches);
            $paragraphs = array_filter(array_map(function ($p) {
                return trim(strip_tags($p));
            }, $pMatches[1] ?? []), fn($p) => strlen($p) > 30);

            $content = implode("\n\n", $paragraphs);

            return [
                'title'    => $title ?: "Hutbe #{$id}",
                'date'     => $date,
                'pdf_url'  => $pdfUrl,
                'word_url' => $wordUrl,
                'content'  => $content ?: null,
            ];
        } catch (\Exception $e) {
            Log::warning("KKTC hutbe detail {$id} error: " . $e->getMessage());
            return null;
        }
    }

    public function pdfToTextAvailable(): bool
    {
        exec('which pdftotext 2>/dev/null', $out, $code);
        return $code === 0 && !empty($out);
    }

    public function extractPdfContent(string $pdfUrl): ?string
    {
        try {
            $response = Http::timeout(30)
                ->withHeaders(['User-Agent' => 'Mozilla/5.0 (compatible; RadyoMevlana/1.0)'])
                ->get($pdfUrl);

            if (!$response->successful()) {
                return null;
            }

            $tmpFile = sys_get_temp_dir() . '/hutbe_' . uniqid() . '.pdf';
            file_put_contents($tmpFile, $response->body());

            $output = [];
            $code   = 0;
            exec("pdftotext -enc UTF-8 '$tmpFile' - 2>/dev/null", $output, $code);
            @unlink($tmpFile);

            if ($code !== 0 || empty($output)) {
                return null;
            }

            $text = implode("\n", $output);
            // Fazla boşlukları temizle, çok kısa içerikleri reddet
            $text = trim(preg_replace('/[ \t]{2,}/', ' ', $text));
            $text = preg_replace('/\n{3,}/', "\n\n", $text);

            return mb_strlen($text) > 100 ? $text : null;
        } catch (\Exception $e) {
            Log::warning("PDF content extraction error for {$pdfUrl}: " . $e->getMessage());
            return null;
        }
    }

    public function syncHutbes(int $limit = 20): int
    {
        $list  = $this->scrapeHutbeList();
        $saved = 0;

        // Sadece yeni olanları al
        $existingIds = Hutbe::pluck('source_id')->toArray();

        foreach (array_slice($list, 0, $limit) as $item) {
            if (in_array($item['id'], $existingIds)) {
                continue;
            }

            $detail = $this->scrapeHutbeDetail($item['id']);

            // Detail page may require login — fall back to list data for file URLs
            $pdfUrl  = ($detail['pdf_url']  ?? null) ?: ($item['pdf_url']  ?? null);
            $wordUrl = ($detail['word_url'] ?? null) ?: ($item['word_url'] ?? null);
            $content = ($detail['content'] ?? null);

            $dateStr = $detail['date'] ?? null;
            if (!$dateStr && !empty($item['date'])) {
                $parts   = explode('.', $item['date']);
                $dateStr = count($parts) === 3 ? "{$parts[2]}-{$parts[1]}-{$parts[0]}" : null;
            }

            Hutbe::create([
                'source_id'  => $item['id'],
                'title'      => ($detail['title'] ?? null) ?: $item['title'],
                'date'       => $dateStr ?? now()->toDateString(),
                'content'    => $content,
                'pdf_url'    => $pdfUrl,
                'word_url'   => $wordUrl,
                'source_url' => self::BASE . '/hutbedetay.php?id=' . $item['id'],
                'is_manual'  => false,
            ]);

            $saved++;
            usleep(300000); // 0.3sn bekleme (server dostu)
        }

        return $saved;
    }

    // ── Duyurular (ana sayfadan çek) ─────────────────────

    public function syncDuyurular(): int
    {
        // Duyurular.php 404 döndüğünden ana sayfadaki duyuru bloklarını parse ediyoruz
        try {
            $res = Http::timeout(15)
                ->withHeaders(['User-Agent' => 'Mozilla/5.0 (compatible; RadyoMevlana/1.0)'])
                ->get(self::BASE);

            if (!$res->successful()) {
                return 0;
            }

            $html  = $res->body();
            $saved = 0;

            // Duyurular linklerini bul — genellikle /duyurudetay.php?id=X formatında
            preg_match_all(
                '/duyurudetay\.php\?id=(\d+)[^>]*>([^<]{5,100})<\/a/i',
                $html,
                $matches,
                PREG_SET_ORDER
            );

            foreach ($matches as $m) {
                $extId = 'kktc_d_' . $m[1];
                if (Announcement::where('external_id', $extId)->exists()) {
                    continue;
                }

                Announcement::create([
                    'category'    => 'duyuru',
                    'source'      => 'kktc',
                    'external_id' => $extId,
                    'title'       => trim(html_entity_decode($m[2], ENT_QUOTES, 'UTF-8')),
                    'source_url'  => self::BASE . '/duyurudetay.php?id=' . $m[1],
                    'is_published' => true,
                ]);
                $saved++;
            }

            return $saved;
        } catch (\Exception $e) {
            Log::warning('KKTC duyuru scrape error: ' . $e->getMessage());
            return 0;
        }
    }
}
