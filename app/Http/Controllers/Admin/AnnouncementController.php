<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Services\EvkafScraperService;
use App\Services\KktcScraperService;
use Illuminate\Http\Request;

class AnnouncementController extends Controller
{
    public function index(Request $request)
    {
        $source = $request->get('source', 'all');
        $announcements = Announcement::when($source !== 'all', fn($q) => $q->where('source', $source))
            ->orderByDesc('published_at')->orderByDesc('id')
            ->paginate(20);

        return view('admin.announcements.index', compact('announcements', 'source'));
    }

    public function create()
    {
        return view('admin.announcements.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'    => 'required|string|max:255',
            'category' => 'required|in:baskan,yazi,duyuru',
        ]);

        Announcement::create($request->only(['title','category','excerpt','content','source_url','published_at']) + [
            'source'     => 'manual',
            'is_published' => $request->boolean('is_published', true),
        ]);

        return redirect()->route('admin.announcements.index')->with('success', 'Yazı/Duyuru eklendi.');
    }

    public function edit(Announcement $announcement)
    {
        return view('admin.announcements.edit', compact('announcement'));
    }

    public function update(Request $request, Announcement $announcement)
    {
        $announcement->update($request->only(['title','category','excerpt','content','source_url','published_at']) + [
            'is_published' => $request->boolean('is_published', true),
        ]);

        return back()->with('success', 'Güncellendi.');
    }

    public function destroy(Announcement $announcement)
    {
        $announcement->delete();
        return back()->with('success', 'Silindi.');
    }

    public function scrapeKktc(KktcScraperService $service)
    {
        $count = $service->syncDuyurular();
        return back()->with('success', "KKTC: {$count} yeni duyuru çekildi.");
    }

    public function scrapeEvkaf(EvkafScraperService $service)
    {
        $h = $service->syncHaberler(2);
        $d = $service->syncDuyurular(2);
        return back()->with('success', "Evkaf: {$h} haber + {$d} duyuru çekildi.");
    }
}
