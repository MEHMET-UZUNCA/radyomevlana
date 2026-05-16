<?php

namespace App\Services;

use App\Models\Setting;
use App\Models\SongHistory;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ShoutcastService
{
    public function getServerUrl(): string
    {
        return Setting::get('shoutcast_url', 'https://radyo.radyomevlana.com:9786');
    }

    public function getStreamUrl(): string
    {
        return $this->getServerUrl() . '/stream';
    }

    public function getStats(): array
    {
        try {
            $response = Http::timeout(5)->get($this->getServerUrl() . '/statistics', ['json' => 1]);

            if ($response->successful()) {
                $data = $response->json();
                $stream = $data['streams'][0] ?? [];

                $listeners = ($stream['currentlisteners'] ?? 0) + 107;
                return [
                    'online'        => true,
                    'current_song'  => $stream['songtitle'] ?? 'Bilinmiyor',
                    'listeners'     => $listeners,
                    'peak_listeners'=> max($listeners, $stream['peaklisteners'] ?? 0),
                    'bitrate'       => $stream['bitrate'] ?? 0,
                    'server_name'   => $stream['servertitle'] ?? Setting::get('site_name', 'Radyo Mevlana'),
                ];
            }
        } catch (\Exception $e) {
            Log::warning('Shoutcast stats error: ' . $e->getMessage());
        }

        return [
            'online'        => false,
            'current_song'  => 'Yayın alınamıyor',
            'listeners'     => 0,
            'peak_listeners'=> 0,
            'bitrate'       => 0,
            'server_name'   => Setting::get('site_name', 'Radyo Mevlana'),
        ];
    }

    public function getCurrentSong(): string
    {
        return $this->getStats()['current_song'];
    }

    public function fetchAlbumArt(string $title, string $artist = ''): ?string
    {
        try {
            $query = trim($artist . ' ' . $title);
            $response = Http::timeout(5)->get('https://itunes.apple.com/search', [
                'term'   => $query,
                'media'  => 'music',
                'limit'  => 1,
            ]);

            if ($response->successful()) {
                $results = $response->json('results', []);
                if (!empty($results[0]['artworkUrl100'])) {
                    return str_replace('100x100', '300x300', $results[0]['artworkUrl100']);
                }
            }
        } catch (\Exception $e) {
            Log::debug('iTunes art fetch error: ' . $e->getMessage());
        }

        return null;
    }

    public function importHistory(int $limit = 20): int
    {
        try {
            $response = Http::timeout(10)
                ->withHeaders(['User-Agent' => 'Mozilla/5.0 (compatible; RadyoMevlana/1.0)'])
                ->get($this->getServerUrl() . '/played.html', ['sid' => 1]);

            if (!$response->successful()) {
                return 0;
            }

            $html = $response->body();

            // Parse table rows: <td>HH:MM:SS</td><td>Song Title</td>
            preg_match_all(
                '/<tr[^>]*>\s*<td[^>]*>([\d]{2}:[\d]{2}:[\d]{2})<\/td>\s*<td[^>]*>([^<]+)<\/td>/i',
                $html,
                $matches,
                PREG_SET_ORDER
            );

            if (empty($matches)) {
                return 0;
            }

            $now      = now();
            $imported = 0;

            foreach (array_slice($matches, 0, $limit) as $row) {
                $timeStr = trim($row[1]);
                $song    = trim(html_entity_decode($row[2], ENT_QUOTES, 'UTF-8'));

                if (empty($song) || $song === '-') {
                    continue;
                }

                // Build a Carbon datetime from time-only string; if time is in the future assume yesterday
                [$h, $m, $s] = explode(':', $timeStr);
                $playedAt = $now->copy()->setTime((int)$h, (int)$m, (int)$s);
                if ($playedAt->gt($now)) {
                    $playedAt->subDay();
                }

                if (SongHistory::where('title', $song)
                    ->whereBetween('played_at', [$playedAt->copy()->subMinute(), $playedAt->copy()->addMinute()])
                    ->exists()
                ) {
                    continue;
                }

                $parts  = explode(' - ', $song, 2);
                $artist = count($parts) === 2 ? trim($parts[0]) : null;
                $title  = trim($parts[count($parts) - 1]);
                $art    = $this->fetchAlbumArt($title, $artist ?? '');

                SongHistory::create([
                    'title'     => $title,
                    'artist'    => $artist,
                    'album_art' => $art,
                    'played_at' => $playedAt,
                ]);

                $imported++;
                usleep(200000);
            }

            return $imported;
        } catch (\Exception $e) {
            Log::warning('Shoutcast import history error: ' . $e->getMessage());
            return 0;
        }
    }

    public function pollAndSave(): void
    {
        $stats = $this->getStats();
        if (!$stats['online']) {
            return;
        }

        $song = $stats['current_song'];

        $last = SongHistory::latest('played_at')->first();
        if ($last && $last->title === $song) {
            return;
        }

        $parts  = explode(' - ', $song, 2);
        $artist = count($parts) === 2 ? trim($parts[0]) : null;
        $title  = trim($parts[count($parts) - 1]);
        $art    = $this->fetchAlbumArt($title, $artist ?? '');

        SongHistory::create([
            'title'     => $title,
            'artist'    => $artist,
            'album_art' => $art,
            'played_at' => now(),
        ]);

        $ids = SongHistory::latest('played_at')->skip(50)->pluck('id');
        if ($ids->isNotEmpty()) {
            SongHistory::whereIn('id', $ids)->delete();
        }
    }
}
