<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NavItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class NavItemController extends Controller
{
    public function index()
    {
        $items = NavItem::orderBy('sort_order')->orderBy('location')->get();
        return view('admin.nav.index', compact('items'));
    }

    public function create()
    {
        return view('admin.nav.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'label'      => 'required|string|max:80',
            'url'        => 'required|string|max:255',
            'location'   => 'required|in:header,footer,both',
            'target'     => 'required|in:_self,_blank',
            'icon'       => 'nullable|string|max:80',
            'sort_order' => 'nullable|integer|min:0|max:999',
            'is_active'  => 'nullable|boolean',
            'is_button'  => 'nullable|boolean',
        ]);

        $data['is_active'] = $request->boolean('is_active', true);
        $data['is_button'] = $request->boolean('is_button');
        $data['sort_order'] = $data['sort_order'] ?? 0;

        NavItem::create($data);
        Cache::forget('nav_header');
        Cache::forget('nav_footer');

        return redirect()->route('admin.nav.index')->with('success', 'Menü öğesi eklendi.');
    }

    public function edit(NavItem $navItem)
    {
        return view('admin.nav.edit', compact('navItem'));
    }

    public function update(Request $request, NavItem $navItem)
    {
        $data = $request->validate([
            'label'      => 'required|string|max:80',
            'url'        => 'required|string|max:255',
            'location'   => 'required|in:header,footer,both',
            'target'     => 'required|in:_self,_blank',
            'icon'       => 'nullable|string|max:80',
            'sort_order' => 'nullable|integer|min:0|max:999',
            'is_active'  => 'nullable|boolean',
            'is_button'  => 'nullable|boolean',
        ]);

        $data['is_active'] = $request->boolean('is_active');
        $data['is_button'] = $request->boolean('is_button');

        $navItem->update($data);
        Cache::forget('nav_header');
        Cache::forget('nav_footer');

        return redirect()->route('admin.nav.index')->with('success', 'Menü öğesi güncellendi.');
    }

    public function destroy(NavItem $navItem)
    {
        $navItem->delete();
        Cache::forget('nav_header');
        Cache::forget('nav_footer');
        return back()->with('success', 'Menü öğesi silindi.');
    }
}
