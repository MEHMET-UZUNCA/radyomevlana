<?php

namespace App\Http\Controllers;

use App\Models\EditorPost;

class EditorController extends Controller
{
    public function index()
    {
        $posts = EditorPost::where('is_published', true)
            ->orderByDesc('published_at')
            ->paginate(9);

        return view('editor.index', compact('posts'));
    }

    public function show(EditorPost $editorPost)
    {
        abort_unless($editorPost->is_published, 404);
        return view('editor.show', compact('editorPost'));
    }
}
