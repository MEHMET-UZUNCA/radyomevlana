<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DailyContent;
use App\Services\DailyContentService;
use Illuminate\Http\Request;

class DailyContentController extends Controller
{
    public function index(Request $request)
    {
        $type     = $request->get('type', 'all');
        $contents = DailyContent::when($type !== 'all', fn($q) => $q->where('type', $type))
            ->orderByDesc('date')
            ->orderByDesc('id')
            ->paginate(20);

        return view('admin.daily-content.index', compact('contents', 'type'));
    }

    public function create()
    {
        return view('admin.daily-content.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'type'       => 'required|in:ayet,hadis,soz',
            'title'      => 'nullable|string|max:255',
            'content_ar' => 'nullable|string',
            'content_tr' => 'required|string',
            'source'     => 'nullable|string|max:255',
            'date'       => 'required|date',
            'is_published' => 'boolean',
        ]);

        DailyContent::create($request->all() + ['is_manual' => true, 'is_published' => $request->boolean('is_published', true)]);

        return redirect()->route('admin.daily-content.index')->with('success', 'İçerik eklendi.');
    }

    public function edit(DailyContent $dailyContent)
    {
        return view('admin.daily-content.edit', compact('dailyContent'));
    }

    public function update(Request $request, DailyContent $dailyContent)
    {
        $request->validate([
            'title'      => 'nullable|string|max:255',
            'content_ar' => 'nullable|string',
            'content_tr' => 'required|string',
            'source'     => 'nullable|string|max:255',
            'date'       => 'required|date',
        ]);

        $dailyContent->update($request->only(['title','content_ar','content_tr','source','date']) + [
            'is_published' => $request->boolean('is_published', true),
            'is_manual'    => true,
        ]);

        return redirect()->route('admin.daily-content.index')->with('success', 'İçerik güncellendi.');
    }

    public function togglePublish(DailyContent $dailyContent)
    {
        $dailyContent->update(['is_published' => !$dailyContent->is_published]);
        return back()->with('success', 'Durum güncellendi.');
    }

    public function fetchToday(DailyContentService $service)
    {
        DailyContent::where('date', today()->toDateString())->where('is_manual', false)->delete();
        $service->fetchAyet();
        $service->fetchHadis();

        return back()->with('success', 'Günlük ayet ve hadis API\'den çekildi.');
    }

    public function destroy(DailyContent $dailyContent)
    {
        $dailyContent->delete();
        return back()->with('success', 'İçerik silindi.');
    }
}
