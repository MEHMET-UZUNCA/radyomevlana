<?php

namespace App\Http\Controllers;

use App\Models\EditorPost;
use App\Models\Setting;
use App\Models\SongHistory;
use App\Models\SongRequest;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;
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
        $stats       = $this->shoutcast->getStats();
        $history     = SongHistory::latest('played_at')->limit(20)->get();
        $prayerTimes = $this->prayer->today();
        $nextPrayer  = $prayerTimes ? $this->prayer->nextPrayer($prayerTimes) : null;

        $ayetSikligi  = (int) Setting::get('ayet_sikligi', 6);
        $hadisSikligi = (int) Setting::get('hadis_sikligi', 6);
        $sozSikligi   = (int) Setting::get('gunun_sozu_sikligi', 6);

        $ayetSlot  = (int) floor(time() / (3600 * $ayetSikligi));
        $hadisSlot = (int) floor(time() / (3600 * $hadisSikligi));
        $sozSlot   = (int) floor(time() / (3600 * $sozSikligi));

        $dailyContents = [
            'ayet'  => $this->daily->getRotatedAyet($ayetSlot, $ayetSikligi),
            'hadis' => $this->daily->getRotatedHadis($hadisSlot, $hadisSikligi),
            'soz'   => null,
        ];

        $sozPool   = EditorPost::where('is_gunun_sozu', true)->where('is_published', true)->orderBy('id')->get();
        $gununSozu = $sozPool->isNotEmpty() ? $sozPool[$sozSlot % $sozPool->count()] : null;

        return view('radio.index', compact('stats', 'history', 'prayerTimes', 'nextPrayer', 'dailyContents', 'gununSozu'));
    }

    public function nowPlaying()
    {
        $stats   = $this->shoutcast->getStats();
        $history = SongHistory::latest('played_at')->limit(20)->get();

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
        // Flood koruması: IP başına 10 dakikada en fazla 3 istek
        $key = 'istek_' . $request->ip();
        if (RateLimiter::tooManyAttempts($key, 3)) {
            $bekle = RateLimiter::availableIn($key);
            return back()->with('error', "Çok sık istek gönderdiniz. " . ceil($bekle / 60) . " dakika sonra tekrar deneyin.");
        }
        RateLimiter::hit($key, 600);

        $validated = $request->validate([
            'name'       => 'required|string|max:100',
            'phone'      => 'nullable|string|max:20',
            'city'       => 'nullable|string|max:100',
            'song_title' => 'required|string|max:200',
            'artist'     => 'nullable|string|max:200',
            'message'    => 'nullable|string|max:500',
        ]);

        // Aynı parça son 20 dakikada zaten istendi mi?
        $duplicate = SongRequest::whereRaw('LOWER(song_title) = ?', [mb_strtolower($validated['song_title'])])
            ->where('created_at', '>=', now()->subMinutes(20))
            ->exists();
        if ($duplicate) {
            return back()->with('error', '"' . $validated['song_title'] . '" son 20 dakika içinde zaten istendi. Biraz sonra tekrar deneyebilirsiniz.');
        }

        SongRequest::create($validated);

        // E-posta bildirimi
        try {
            $body  = "🎵 Yeni parça isteği\n\n";
            $body .= "Parça   : " . $validated['song_title'] . "\n";
            $body .= "Sanatçı : " . ($validated['artist']  ?? '—') . "\n";
            $body .= "Ad      : " . $validated['name'] . "\n";
            $body .= "Telefon : " . ($validated['phone']   ?? '—') . "\n";
            $body .= "Şehir   : " . ($validated['city']    ?? '—') . "\n";
            $body .= "Not     : " . ($validated['message'] ?? '—') . "\n";
            $body .= "\nTarih: " . now()->format('d.m.Y H:i') . "\n";
            $body .= "IP   : " . $request->ip();

            Mail::raw($body, function ($m) use ($validated) {
                $m->to('mehmetuzunca85@gmail.com')
                  ->from(config('mail.from.address'), 'Radyo Mevlana')
                  ->subject('🎵 Yeni İstek: ' . $validated['song_title']);
            });
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::warning('İstek mail hatası: ' . $e->getMessage());
        }

        return back()->with('success', 'İsteğiniz alındı, teşekkür ederiz!');
    }
}
