<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Hutbe;
use App\Services\KktcScraperService;
use Illuminate\Http\Request;

class HutbeController extends Controller
{
    public function index()
    {
        $hutbes = Hutbe::orderByDesc('date')->paginate(20);
        return view('admin.hutbe.index', compact('hutbes'));
    }

    public function create()
    {
        return view('admin.hutbe.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'date'  => 'required|date',
        ]);

        Hutbe::create($request->only(['title','date','content','pdf_url','word_url']) + ['is_manual' => true]);

        return redirect()->route('admin.hutbe.index')->with('success', 'Hutbe eklendi.');
    }

    public function edit(Hutbe $hutbe)
    {
        return view('admin.hutbe.edit', compact('hutbe'));
    }

    public function update(Request $request, Hutbe $hutbe)
    {
        $hutbe->update($request->only(['title','date','content','pdf_url','word_url']) + [
            'is_published' => $request->boolean('is_published', true),
        ]);

        return back()->with('success', 'Hutbe güncellendi.');
    }

    public function destroy(Hutbe $hutbe)
    {
        $hutbe->delete();
        return back()->with('success', 'Hutbe silindi.');
    }

    public function scrape(KktcScraperService $service)
    {
        $count = $service->syncHutbes(20);
        return back()->with('success', "{$count} yeni hutbe çekildi.");
    }
}
