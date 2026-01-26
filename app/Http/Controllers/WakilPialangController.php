<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\KantorCabang;
use App\Models\Setting;
use App\Models\WakilPialang;

class WakilPialangController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); // opsional bila area admin
    }

    /**
     * List data (pagination + optional search).
     */
    public function index(Request $request)
    {
        $search = $request->query('search');
        $kantorCabangId = $request->query('kantor_cabang_id');
        $kantorCabangs = KantorCabang::query()->orderBy('nama_kantor_cabang')->get();
        $setting = Setting::query()->first();
        $kantorPusatLabel = $setting?->web_title ? "Kantor Pusat - {$setting->web_title}" : 'Kantor Pusat';

        $wakilPialangs = WakilPialang::query()
            ->with('kantorCabang')
            ->when($search, function ($q) use ($search) {
                $q->where('nomor_id', 'like', "%{$search}%")
                    ->orWhere('nama', 'like', "%{$search}%")
                    ->orWhere('status', 'like', "%{$search}%");
            })
            ->when($kantorCabangId, function ($q) use ($kantorCabangId) {
                $kantorCabangId = (int) $kantorCabangId;
                if ($kantorCabangId === 0) {
                    $q->whereNull('kantor_cabang_id');
                    return;
                }
                $q->where('kantor_cabang_id', $kantorCabangId);
            })
            ->latest()
            ->paginate(10)
            ->appends(['search' => $search, 'kantor_cabang_id' => $kantorCabangId]);

        return view('wakil-pialang.index', compact(
            'wakilPialangs',
            'kantorCabangs',
            'kantorCabangId',
            'kantorPusatLabel',
        ));
    }

    /**
     * Form create.
     */
    public function create()
    {
        $kantorCabangs = KantorCabang::query()->orderBy('nama_kantor_cabang')->get();
        $setting = Setting::query()->first();
        $kantorPusatLabel = $setting?->web_title ? "Kantor Pusat - {$setting->web_title}" : 'Kantor Pusat';

        return view('wakil-pialang.create', compact('kantorCabangs', 'kantorPusatLabel'));
    }

    /**
     * Simpan data baru (gambar disimpan ke public/uploads/wakil-pialang).
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'kantor_cabang_id' => 'required|integer|min:0',
            'image'    => 'required|image|mimes:jpg,jpeg,png,gif,webp|max:3072', // 3MB
            'nomor_id' => 'required|string|max:25',
            'nama'     => 'required|string|max:100',
            'status'   => 'required|in:Aktif,Non-Aktif',
        ]);

        try {
            $kantorCabangId = (int) $validated['kantor_cabang_id'];

            $cabangFolder = 'kantor-pusat';
            if ($kantorCabangId !== 0) {
                $kantorCabang = KantorCabang::find($kantorCabangId);
                if (! $kantorCabang) {
                    return back()->withErrors(['kantor_cabang_id' => 'Cabang tidak valid.'])->withInput();
                }

                $cabangFolder = Str::slug($kantorCabang->nama_kantor_cabang) ?: 'cabang';
            }

            // Pastikan folder ada
            $dest = public_path("uploads/wakil-pialang/{$cabangFolder}");
            if (! is_dir($dest)) {
                mkdir($dest, 0775, true);
            }

            // Simpan file ke public/
            $file     = $request->file('image');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move($dest, $filename);

            // Simpan path relatif agar mudah dipakai di view
            $validated['image'] = "uploads/wakil-pialang/{$cabangFolder}/{$filename}";
            $validated['kantor_cabang_id'] = $kantorCabangId === 0 ? null : $kantorCabangId;

            WakilPialang::create($validated);

            return redirect()->route('wakil-pialang.index')->with('success', 'Wakil pialang berhasil ditambahkan.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menambahkan data: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Form edit.
     */
    public function edit($id)
    {
        $wakilPialang = WakilPialang::findOrFail($id);
        $kantorCabangs = KantorCabang::query()->orderBy('nama_kantor_cabang')->get();
        $setting = Setting::query()->first();
        $kantorPusatLabel = $setting?->web_title ? "Kantor Pusat - {$setting->web_title}" : 'Kantor Pusat';

        return view('wakil-pialang.edit', compact('wakilPialang', 'kantorCabangs', 'kantorPusatLabel'));
    }

    /**
     * Update data (gambar opsional; jika diunggah, hapus yang lama).
     */
    public function update(Request $request, $id)
    {
        $wakilPialang = WakilPialang::findOrFail($id);

        $validated = $request->validate([
            'kantor_cabang_id' => 'required|integer|min:0',
            'image'    => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:3072',
            'nomor_id' => 'required|string|max:25',
            'nama'     => 'required|string|max:100',
            'status'   => 'required|in:Aktif,Non-Aktif',
        ]);

        try {
            $kantorCabangId = (int) $validated['kantor_cabang_id'];

            $cabangFolder = 'kantor-pusat';
            if ($kantorCabangId !== 0) {
                $kantorCabang = KantorCabang::find($kantorCabangId);
                if (! $kantorCabang) {
                    return back()->withErrors(['kantor_cabang_id' => 'Cabang tidak valid.'])->withInput();
                }

                $cabangFolder = Str::slug($kantorCabang->nama_kantor_cabang) ?: 'cabang';
            }

            if ($request->hasFile('image')) {
                // Hapus file lama jika ada
                if ($wakilPialang->image && file_exists(public_path($wakilPialang->image))) {
                    @unlink(public_path($wakilPialang->image));
                }

                // Pastikan folder ada
                $dest = public_path("uploads/wakil-pialang/{$cabangFolder}");
                if (! is_dir($dest)) {
                    mkdir($dest, 0775, true);
                }

                // Simpan file baru
                $file     = $request->file('image');
                $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move($dest, $filename);
                $validated['image'] = "uploads/wakil-pialang/{$cabangFolder}/{$filename}";
            }

            $validated['kantor_cabang_id'] = $kantorCabangId === 0 ? null : $kantorCabangId;
            $wakilPialang->update($validated);

            return redirect()->route('wakil-pialang.index')->with('success', 'Wakil pialang berhasil diperbarui.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal memperbarui data: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Hapus data + file gambar.
     */
    public function destroy($id)
    {
        $wakilPialang = WakilPialang::find($id);

        if (! $wakilPialang) {
            return redirect()->route('wakil-pialang.index')->with('error', 'Data tidak ditemukan.');
        }

        try {
            if ($wakilPialang->image && file_exists(public_path($wakilPialang->image))) {
                @unlink(public_path($wakilPialang->image));
            }

            $wakilPialang->delete();

            return redirect()->route('wakil-pialang.index')->with('success', 'Data berhasil dihapus.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }
}
