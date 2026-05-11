<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class BannerController extends Controller
{
    public function index()
    {
        $banners = Banner::orderBy('location')->orderBy('sort_order')->get();
        return view('admin.banners.index', compact('banners'));
    }

    public function create()
    {
        return view('admin.banners.form', ['banner' => new Banner, 'locations' => Banner::locations()]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        Banner::create($data);
        $this->clearCache();
        return redirect()->route('admin.banners.index')->with('success', 'Banner eklendi.');
    }

    public function edit(Banner $banner)
    {
        return view('admin.banners.form', compact('banner') + ['locations' => Banner::locations()]);
    }

    public function update(Request $request, Banner $banner)
    {
        $banner->update($this->validated($request));
        $this->clearCache();
        return redirect()->route('admin.banners.index')->with('success', 'Banner güncellendi.');
    }

    public function destroy(Banner $banner)
    {
        $banner->delete();
        $this->clearCache();
        return back()->with('success', 'Banner silindi.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'name'         => ['required', 'max:120'],
            'location'     => ['required', 'in:' . implode(',', array_keys(Banner::locations()))],
            'image_url'    => ['required', 'url', 'max:500'],
            'link_url'     => ['nullable', 'url', 'max:500'],
            'link_target'  => ['in:_blank,_self'],
            'alt_text'     => ['nullable', 'max:200'],
            'is_active'    => ['boolean'],
            'sort_order'   => ['integer', 'min:0'],
            'starts_at'    => ['nullable', 'date'],
            'ends_at'      => ['nullable', 'date', 'after_or_equal:starts_at'],
        ]);
    }

    private function clearCache(): void
    {
        foreach (array_keys(Banner::locations()) as $loc) {
            Cache::forget("banners_{$loc}");
        }
    }
}
