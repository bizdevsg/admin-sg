<?php

namespace App\Http\Controllers;

use App\Models\Informasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class InformasiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $search = $request->query('search');

        $informasis = Informasi::when($search, function ($query) use ($search) {
            $query->where('title', 'like', "%{$search}%");
        })
            ->latest()
            ->paginate(10)
            ->appends(['search' => $search]);

        return view('informasi.index', compact('informasis', 'search'));
    }

    public function show($id)
    {
        $informasi = Informasi::findOrFail($id);

        return view('informasi.show', compact('informasi'));
    }

    public function create()
    {
        return view('informasi.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'   => 'required|string|max:150',
            'content' => 'required|string',
            'image'   => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:2048',
        ]);

        try {
            $imagePath = null;

            if ($request->hasFile('image')) {
                $imagePath = $this->saveImageToPublic($request->file('image'));
            }

            Informasi::create([
                'title'   => $validated['title'],
                'content' => $validated['content'],
                'image'   => $imagePath,
            ]);

            return redirect()->route('informasi.index')->with('success', 'Informasi berhasil ditambahkan!');
        } catch (\Throwable $e) {
            return back()
                ->withInput()
                ->with('error', 'Gagal menambahkan informasi: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $informasi = Informasi::findOrFail($id);

        return view('informasi.edit', compact('informasi'));
    }

    public function update(Request $request, $id)
    {
        $informasi = Informasi::findOrFail($id);

        $validated = $request->validate([
            'title'   => 'required|string|max:150',
            'content' => 'required|string',
            'image'   => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:2048',
        ]);

        try {
            $data = [
                'title'   => $validated['title'],
                'content' => $validated['content'],
            ];

            if ($request->hasFile('image')) {
                if ($informasi->image && File::exists(public_path($informasi->image))) {
                    File::delete(public_path($informasi->image));
                }

                $data['image'] = $this->saveImageToPublic($request->file('image'));
            }

            $informasi->update($data);

            return redirect()->route('informasi.index')->with('success', 'Informasi berhasil diperbarui!');
        } catch (\Throwable $e) {
            return back()
                ->withInput()
                ->with('error', 'Gagal memperbarui informasi: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $informasi = Informasi::find($id);

        if (! $informasi) {
            return redirect()->route('informasi.index')->with('error', 'Informasi tidak ditemukan.');
        }

        try {
            if ($informasi->image && File::exists(public_path($informasi->image))) {
                File::delete(public_path($informasi->image));
            }

            $informasi->delete();

            return redirect()->route('informasi.index')->with('success', 'Informasi berhasil dihapus.');
        } catch (\Throwable $e) {
            return redirect()->route('informasi.index')->with('error', 'Gagal menghapus informasi: ' . $e->getMessage());
        }
    }

    protected function saveImageToPublic($file): string
    {
        $destination = public_path('uploads/informasi');

        if (! File::isDirectory($destination)) {
            File::makeDirectory($destination, 0755, true);
        }

        $extension = strtolower($file->getClientOriginalExtension());
        $filename = time() . '_' . Str::random(12) . '.' . $extension;

        $file->move($destination, $filename);

        return 'uploads/informasi/' . $filename;
    }
}
