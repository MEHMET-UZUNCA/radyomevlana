<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Models\SongHistory;
use App\Models\SongRequest;
use App\Services\DailyContentService;
use App\Services\PrayerTimeService;
use App\Services\ShoutcastService;
use Illuminate\Http\Request;

class RadioController extends Controller
{
    public function __construct(
        private ShoutcastService $shoutcast,
        private PrayerTimeService $prayer,
        private DailyContentService $daily,
    ) {}

    public function index()
    {
        $stats         = $this->shoutcast->getStats();
        $history       = SongHistory::latest('played_at')->limit(10)->get();
        $prayerTimes   = $this->prayer->today();
        $nextPrayer    = $prayerTimes ? $this->prayer->nextPrayer($prayerTimes) : null;
        $dailyContents = $this->daily->getToday();

        return view('radio.index', compact('stats', 'history', 'prayerTimes', 'nextPrayer', 'dailyContents'));
    }

    public function nowPlaying()
    {
        $stats   = $this->shoutcast->getStats();
        $history = SongHistory::latest('played_at')->limit(10)->get();

        return response()->json([
            'current_song'  => $stats['current_song'],
            'listeners'     => $stats['listeners'],
            'online'        => $stats['online'],
            'stream_url'    => $this->shoutcast->getStreamUrl(),
            'history'       => $history->map(fn($s) => [
                'id'        => $s->id,
                'title'     => $s->title,
                'artist'    => $s->artist,
                'album_art' => $s->album_art,
                'played_at' => $s->played_at?->diffForHumans(),
            ]),
        ]);
    }

    public function requestStore(Request $request)
    {
        $validated = $request->validate([
            'name'       => 'required|string|max:100',
            'phone'      => 'nullable|string|max:20',
            'city'       => 'nullable|string|max:100',
            'song_title' => 'required|string|max:200',
            'artist'     => 'nullable|string|max:200',
            'message'    => 'nullable|string|max:500',
        ]);

        SongRequest::create($validated);

        return back()->with('success', 'İsteğiniz alındı, teşekkür ederiz!');
    }
}
