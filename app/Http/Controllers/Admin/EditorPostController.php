<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EditorPost;
use Illuminate\Http\Request;

class EditorPostController extends Controller
{
    public function index()
    {
        $posts = EditorPost::orderByDesc('published_at')->paginate(20);
        return view('admin.editor.index', compact('posts'));
    }

    public function create()
    {
        return view('admin.editor.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'   => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        EditorPost::create([
            'title'        => $request->title,
            'excerpt'      => $request->excerpt ?: mb_substr(strip_tags($request->content), 0, 200),
            'content'      => $request->content,
            'image'        => $request->image,
            'is_published' => $request->boolean('is_published', true),
            'published_at' => $request->published_at ?? now(),
        ]);

        return redirect()->route('admin.editor.index')->with('success', 'Yazı eklendi.');
    }

    public function edit(EditorPost $editorPost)
    {
        return view('admin.editor.edit', compact('editorPost'));
    }

    public function update(Request $request, EditorPost $editorPost)
    {
        $editorPost->update([
            'title'        => $request->title,
            'excerpt'      => $request->excerpt ?: mb_substr(strip_tags($request->content), 0, 200),
            'content'      => $request->content,
            'image'        => $request->image,
            'is_published' => $request->boolean('is_published', true),
            'published_at' => $request->published_at ?? $editorPost->published_at,
        ]);

        return back()->with('success', 'Yazı güncellendi.');
    }

    public function destroy(EditorPost $editorPost)
    {
        $editorPost->delete();
        return back()->with('success', 'Yazı silindi.');
    }
}
