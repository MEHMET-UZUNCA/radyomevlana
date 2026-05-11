<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PageSeo;
use Illuminate\Http\Request;

class PageSeoController extends Controller
{
    public function index()
    {
        $seos = PageSeo::orderBy('path')->get();
        return view('admin.seo.index', compact('seos'));
    }

    public function create()
    {
        return view('admin.seo.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'path'        => 'required|string|max:255|unique:page_seos,path',
            'title'       => 'nullable|string|max:120',
            'description' => 'nullable|string|max:320',
            'keywords'    => 'nullable|string|max:320',
            'og_title'    => 'nullable|string|max:120',
            'og_image'    => 'nullable|url|max:500',
        ]);

        // Normalize path
        $data['path'] = '/' . ltrim($data['path'], '/');

        PageSeo::create($data);
        return redirect()->route('admin.seo.index')->with('success', 'SEO kaydı oluşturuldu.');
    }

    public function edit(PageSeo $pageSeo)
    {
        return view('admin.seo.edit', compact('pageSeo'));
    }

    public function update(Request $request, PageSeo $pageSeo)
    {
        $data = $request->validate([
            'path'        => 'required|string|max:255|unique:page_seos,path,' . $pageSeo->id,
            'title'       => 'nullable|string|max:120',
            'description' => 'nullable|string|max:320',
            'keywords'    => 'nullable|string|max:320',
            'og_title'    => 'nullable|string|max:120',
            'og_image'    => 'nullable|url|max:500',
        ]);

        $data['path'] = '/' . ltrim($data['path'], '/');

        $pageSeo->update($data);
        return redirect()->route('admin.seo.index')->with('success', 'SEO kaydı güncellendi.');
    }

    public function destroy(PageSeo $pageSeo)
    {
        $pageSeo->delete();
        return back()->with('success', 'SEO kaydı silindi.');
    }
}
