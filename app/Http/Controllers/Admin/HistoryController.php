<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SongHistory;

class HistoryController extends Controller
{
    public function index()
    {
        $history = SongHistory::latest('played_at')->paginate(30);
        return view('admin.history.index', compact('history'));
    }

    public function destroy(SongHistory $songHistory)
    {
        $songHistory->delete();
        return back()->with('success', 'Kayıt silindi.');
    }
}
