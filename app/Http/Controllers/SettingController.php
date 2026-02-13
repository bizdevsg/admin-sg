<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); // opsional, jika area admin
    }

    /**
     * Tampilkan halaman pengaturan (form).
     */
    public function index()
    {
        $setting = Setting::first(); // bisa null kalau belum ada
        return view('settings.index', compact('setting'));
    }

    /**
     * Simpan pengaturan baru (jika belum ada).
     */
    public function store(Request $request)
    {
        // Validasi
        $validated = $request->validate([
            'web_title'       => 'required|string|max:100',
            'web_description' => 'required|string',
            'address'         => 'required|string',
            'maps_link'       => 'required|string',
            'link_pengaduan'  => 'nullable|string',
            'mailto_link'    => 'nullable|string',
            'phone'           => 'required|string|max:20',
            'fax'             => 'required|string|max:20',
            'email'           => 'required|email|max:100',
        ]);

        try {
            // Pastikan tidak membuat lebih dari satu baris konfigurasi
            if (Setting::exists()) {
                return redirect()
                    ->route('settings.index')
                    ->with('error', 'Pengaturan sudah ada. Silakan gunakan form update.');
            }

            Setting::create($validated);

            return redirect()
                ->route('settings.index')
                ->with('success', 'Pengaturan berhasil dibuat.');
        } catch (\Exception $e) {
            return redirect()
                ->route('settings.index')
                ->with('error', 'Gagal menyimpan pengaturan: ' . $e->getMessage());
        }
    }

    /**
     * Tampilkan (opsional, jarang dibutuhkan untuk settings tunggal).
     */
    public function show(string $id)
    {
        $setting = Setting::findOrFail($id);
        return view('settings.show', compact('setting'));
    }

    /**
     * Halaman edit (opsional; banyak kasus cukup index saja sebagai form).
     */
    public function edit(string $id)
    {
        $setting = Setting::findOrFail($id);
        return view('settings.edit', compact('setting'));
    }

    /**
     * Update pengaturan.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'web_title'       => 'required|string|max:100',
            'web_description' => 'nullable|string',
            'address'         => 'nullable|string',
            'maps_link'       => 'nullable|string',
            'link_pengaduan'  => 'nullable|string',
            'mailto_link'    => 'nullable|string',
            'phone'           => 'nullable|string|max:20',
            'fax'             => 'nullable|string|max:20',
            'email'           => 'nullable|email|max:100',
        ]);

        try {
            $setting = Setting::findOrFail($id);
            $setting->update($validated);

            return redirect()
                ->route('settings.index')
                ->with('success', 'Pengaturan berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()
                ->route('settings.index')
                ->with('error', 'Gagal memperbarui pengaturan: ' . $e->getMessage());
        }
    }

    /**
     * Hapus pengaturan (opsional).
     */
    public function destroy(string $id)
    {
        try {
            $setting = Setting::findOrFail($id);
            $setting->delete();

            return redirect()
                ->route('settings.index')
                ->with('success', 'Pengaturan berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()
                ->route('settings.index')
                ->with('error', 'Gagal menghapus pengaturan: ' . $e->getMessage());
        }
    }

    /**
     * Alternatif: menyimpan atau memperbarui dalam satu endpoint (opsional).
     * Bisa kamu panggil dari route POST /settings/upsert
     */
    public function upsert(Request $request)
    {
        $validated = $request->validate([
            'web_title'       => 'required|string|max:100',
            'web_description' => 'nullable|string',
            'address'         => 'nullable|string',
            'maps_link'       => 'nullable|string',
            'link_pengaduan'  => 'nullable|string',
            'mailto_link'    => 'nullable|string',
            'phone'           => 'nullable|string|max:20',
            'fax'             => 'nullable|string|max:20',
            'email'           => 'nullable|email|max:100',
        ]);

        try {
            $setting = Setting::first();
            if ($setting) {
                $setting->update($validated);
                $msg = 'Pengaturan berhasil diperbarui.';
            } else {
                Setting::create($validated);
                $msg = 'Pengaturan berhasil dibuat.';
            }

            return redirect()
                ->route('settings.index')
                ->with('success', $msg);
        } catch (\Exception $e) {
            return redirect()
                ->route('settings.index')
                ->with('error', 'Gagal menyimpan pengaturan: ' . $e->getMessage());
        }
    }
}
