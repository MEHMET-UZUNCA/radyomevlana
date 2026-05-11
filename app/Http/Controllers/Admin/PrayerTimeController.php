<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PrayerTime;
use App\Services\PrayerTimeService;
use Illuminate\Http\Request;

class PrayerTimeController extends Controller
{
    public function index()
    {
        $times = PrayerTime::orderByDesc('date')->paginate(30);
        $today = PrayerTime::today();
        return view('admin.prayer-times.index', compact('times', 'today'));
    }

    public function edit(PrayerTime $prayerTime)
    {
        return view('admin.prayer-times.edit', compact('prayerTime'));
    }

    public function update(Request $request, PrayerTime $prayerTime)
    {
        $request->validate([
            'imsak'   => 'required|date_format:H:i',
            'fajr'    => 'required|date_format:H:i',
            'sunrise' => 'required|date_format:H:i',
            'dhuhr'   => 'required|date_format:H:i',
            'asr'     => 'required|date_format:H:i',
            'maghrib' => 'required|date_format:H:i',
            'isha'    => 'required|date_format:H:i',
        ]);

        $prayerTime->update($request->only(['imsak','fajr','sunrise','dhuhr','asr','maghrib','isha']) + ['is_manual' => true]);

        return back()->with('success', 'Ezan vakitleri güncellendi.');
    }

    public function storeManual(Request $request)
    {
        $request->validate([
            'date'    => 'required|date',
            'imsak'   => 'required|date_format:H:i',
            'fajr'    => 'required|date_format:H:i',
            'sunrise' => 'required|date_format:H:i',
            'dhuhr'   => 'required|date_format:H:i',
            'asr'     => 'required|date_format:H:i',
            'maghrib' => 'required|date_format:H:i',
            'isha'    => 'required|date_format:H:i',
        ]);

        PrayerTime::updateOrCreate(
            ['date' => $request->date],
            $request->only(['imsak','fajr','sunrise','dhuhr','asr','maghrib','isha']) + ['is_manual' => true]
        );

        return back()->with('success', 'Ezan vakitleri kaydedildi.');
    }

    public function fetchToday(PrayerTimeService $service)
    {
        PrayerTime::where('date', today()->toDateString())->delete();
        $result = $service->fetchAndStore();

        return back()->with('success', $result ? 'Vakitler API\'den çekildi.' : 'API\'den çekilemedi.');
    }

    public function destroy(PrayerTime $prayerTime)
    {
        $prayerTime->delete();
        return back()->with('success', 'Kayıt silindi.');
    }
}
