<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SongRequest;
use Illuminate\Http\Request;

class RequestController extends Controller
{
    public function index(Request $request)
    {
        $status   = $request->get('status', 'pending');
        $requests = SongRequest::when($status !== 'all', fn($q) => $q->where('status', $status))
            ->latest()
            ->paginate(20);

        return view('admin.requests.index', compact('requests', 'status'));
    }

    public function updateStatus(SongRequest $songRequest, string $status)
    {
        $allowed = ['approved', 'played', 'rejected', 'pending'];
        if (!in_array($status, $allowed)) {
            abort(422);
        }

        $songRequest->update([
            'status'    => $status,
            'played_at' => $status === 'played' ? now() : $songRequest->played_at,
        ]);

        return back()->with('success', 'Durum güncellendi.');
    }

    public function destroy(SongRequest $songRequest)
    {
        $songRequest->delete();
        return back()->with('success', 'İstek silindi.');
    }
}
