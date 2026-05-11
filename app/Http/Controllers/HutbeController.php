<?php

namespace App\Http\Controllers;

use App\Models\Hutbe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class HutbeController extends Controller
{
    public function index(Request $request)
    {
        $hutbes = Hutbe::where('is_published', true)
            ->orderByDesc('date')
            ->paginate(12);

        return view('hutbe.index', compact('hutbes'));
    }

    public function show(Hutbe $hutbe)
    {
        abort_unless($hutbe->is_published, 404);
        return view('hutbe.show', compact('hutbe'));
    }

    public function download(Hutbe $hutbe, string $type)
    {
        abort_unless($hutbe->is_published, 404);
        $url = match($type) {
            'pdf'  => $hutbe->pdf_url,
            'word' => $hutbe->word_url,
            default => null,
        };
        abort_unless($url, 404);

        // Dosyayı proxy ile indir (CORS sorunlarını önler)
        try {
            $response = Http::timeout(30)->get($url);
            $ext      = $type === 'pdf' ? 'pdf' : 'docx';
            $filename = \Illuminate\Support\Str::slug($hutbe->title) . '.' . $ext;

            return response($response->body(), 200, [
                'Content-Type'        => $type === 'pdf' ? 'application/pdf' : 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                'Content-Disposition' => "attachment; filename=\"{$filename}\"",
            ]);
        } catch (\Exception $e) {
            return redirect($url);
        }
    }
}
