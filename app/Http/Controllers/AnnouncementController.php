<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use Illuminate\Http\Request;

class AnnouncementController extends Controller
{
    public function index(Request $request)
    {
        $source = $request->get('source', 'kktc'); // kktc | evkaf
        $announcements = Announcement::where('is_published', true)
            ->when($source !== 'all', fn($q) => $q->where('source', $source))
            ->orderByDesc('published_at')
            ->orderByDesc('id')
            ->paginate(15);

        return view('announcements.index', compact('announcements', 'source'));
    }

    public function show(Announcement $announcement)
    {
        abort_unless($announcement->is_published, 404);
        return view('announcements.show', compact('announcement'));
    }
}
