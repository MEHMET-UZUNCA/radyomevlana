<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PageController extends Controller
{
    public function index()
    {
        $pages = Page::orderBy('title')->get();
        return view('admin.pages.index', compact('pages'));
    }

    public function create()
    {
        return view('admin.pages.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'            => 'required|string|max:200',
            'slug'             => 'nullable|string|max:200',
            'excerpt'          => 'nullable|string|max:400',
            'content'          => 'required|string',
            'meta_description' => 'nullable|string|max:320',
        ]);

        $slug = $request->slug
            ? Str::slug($request->slug)
            : Str::slug($request->title);

        if (Page::where('slug', $slug)->exists()) {
            $slug .= '-' . time();
        }

        $page = Page::create([
            'title'            => $request->title,
            'slug'             => $slug,
            'excerpt'          => $request->excerpt,
            'content'          => $request->content,
            'meta_description' => $request->meta_description,
            'is_published'     => $request->boolean('is_published', true),
        ]);

        return redirect()->route('admin.pages.index')
            ->with('success', "Sayfa oluşturuldu. URL: /sayfa/{$page->slug}");
    }

    public function edit(Page $page)
    {
        return view('admin.pages.edit', compact('page'));
    }

    public function update(Request $request, Page $page)
    {
        $request->validate([
            'title'            => 'required|string|max:200',
            'slug'             => 'nullable|string|max:200',
            'excerpt'          => 'nullable|string|max:400',
            'content'          => 'required|string',
            'meta_description' => 'nullable|string|max:320',
        ]);

        $slug = $request->slug
            ? Str::slug($request->slug)
            : Str::slug($request->title);

        if (Page::where('slug', $slug)->where('id', '!=', $page->id)->exists()) {
            $slug .= '-' . time();
        }

        $page->update([
            'title'            => $request->title,
            'slug'             => $slug,
            'excerpt'          => $request->excerpt,
            'content'          => $request->content,
            'meta_description' => $request->meta_description,
            'is_published'     => $request->boolean('is_published'),
        ]);

        return redirect()->route('admin.pages.index')->with('success', 'Sayfa güncellendi.');
    }

    public function destroy(Page $page)
    {
        $page->delete();
        return back()->with('success', 'Sayfa silindi.');
    }
}
