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

                return [
                    'online'        => true,
                    'current_song'  => $stream['songtitle'] ?? 'Bilinmiyor',
                    'listeners'     => $stream['currentlisteners'] ?? 0,
                    'peak_listeners'=> $stream['peaklisteners'] ?? 0,
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
