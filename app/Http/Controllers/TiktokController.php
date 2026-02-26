<?php

namespace App\Http\Controllers;

use App\Models\TiktokLink;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TiktokController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->query('search');

        $tiktoks = TiktokLink::when($search, function ($query, $search) {
            return $query->where('title', 'LIKE', "%{$search}%");
        })
            ->latest()
            ->paginate(10)
            ->appends(['search' => $search]);

        return view('tiktok.index', compact('tiktoks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('tiktok.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'nullable|string|max:100',
            'embed_code' => 'required|string',
            'backup_video' => 'nullable|file|mimes:mp4,mov,mkv,webm|max:51200',
        ]);

        try {
            if ($request->hasFile('backup_video')) {
                $validated['backup_video_path'] = $request->file('backup_video')
                    ->store('tiktok_backups', 'public');
            }

            TiktokLink::create($validated);

            return redirect()->route('tiktok.index')->with('success', 'Link TikTok berhasil ditambahkan!');
        } catch (\Exception $e) {
            return redirect()->route('tiktok.index')->with('error', 'Gagal menambahkan link TikTok! ' . $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $tiktok = TiktokLink::findOrFail($id);
        return view('tiktok.edit', compact('tiktok'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $tiktok = TiktokLink::findOrFail($id);

        $validated = $request->validate([
            'title' => 'nullable|string|max:100',
            'embed_code' => 'required|string',
            'backup_video' => 'nullable|file|mimes:mp4,mov,mkv,webm|max:51200',
        ]);

        try {
            if ($request->hasFile('backup_video')) {
                if ($tiktok->backup_video_path) {
                    Storage::disk('public')->delete($tiktok->backup_video_path);
                }

                $validated['backup_video_path'] = $request->file('backup_video')
                    ->store('tiktok_backups', 'public');
            }

            $tiktok->update($validated);

            return redirect()->route('tiktok.index')->with('success', 'Link TikTok berhasil diperbarui!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal memperbarui link TikTok! ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $tiktok = TiktokLink::find($id);

        if (! $tiktok) {
            return redirect()->route('tiktok.index')->with('error', 'Data TikTok tidak ditemukan.');
        }

        if ($tiktok->backup_video_path) {
            Storage::disk('public')->delete($tiktok->backup_video_path);
        }

        $tiktok->delete();

        return redirect()->route('tiktok.index')->with('success', 'Link TikTok berhasil dihapus.');
    }
}
