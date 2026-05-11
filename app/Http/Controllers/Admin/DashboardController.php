<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SongHistory;
use App\Models\SongRequest;
use App\Services\ShoutcastService;

class DashboardController extends Controller
{
    public function index(ShoutcastService $shoutcast)
    {
        return view('admin.dashboard', [
            'stats'          => $shoutcast->getStats(),
            'total_requests' => SongRequest::count(),
            'pending'        => SongRequest::where('status', 'pending')->count(),
            'played'         => SongRequest::where('status', 'played')->count(),
            'total_songs'    => SongHistory::count(),
            'recent_history' => SongHistory::latest('played_at')->limit(5)->get(),
        ]);
    }
}
