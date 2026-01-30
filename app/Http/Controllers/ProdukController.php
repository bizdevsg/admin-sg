<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Tampilkan semua produk
     */
    public function index()
    {
        $produks = Produk::all();
        return view('produk.index', compact('produks'));
    }

    public function show($slug)
    {
        $produk = Produk::where('slug', $slug)->firstOrFail();

        return view('produk.show', compact('produk'));
    }

    /**
     * Form tambah produk
     */
    public function create()
    {
        return view('produk.create');
    }

    /**
     * Simpan produk baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_produk'      => 'required|string|max:255',
            'deskripsi_produk' => 'required|string',
            'specs'            => 'nullable|string',
            'image'            => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'kategori'         => 'required|string|in:SPA,JFX',
        ]);

        $data = $request->only(['nama_produk', 'deskripsi_produk', 'specs', 'kategori']);

        // upload image ke public/uploads/produk
        if ($request->hasFile('image')) {
            $file     = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/produk'), $filename);
            $data['image'] = 'uploads/produk/' . $filename;
        }

        Produk::create($data);

        return redirect()->route('produk.index')->with('success', 'Produk berhasil ditambahkan!');
    }

    /**
     * Form edit produk
     */
    public function edit($id)
    {
        $produk = Produk::findorfail($id);

        return view('produk.edit', compact('produk'));
    }

    /**
     * Update produk
     */
    public function update(Request $request, $id)
    {
        $produk = Produk::findOrFail($id);

        $request->validate([
            'nama_produk'      => 'required|string|max:255',
            'deskripsi_produk' => 'required|string',
            'specs'            => 'nullable|string',
            'image'            => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'kategori'         => 'required|string|in:SPA,JFX',
        ]);

        $data = $request->only(['nama_produk', 'deskripsi_produk', 'specs', 'kategori']);

        if ($request->hasFile('image')) {
            if ($produk->image && file_exists(public_path($produk->image))) {
                unlink(public_path($produk->image));
            }

            $file     = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/produk'), $filename);
            $data['image'] = 'uploads/produk/' . $filename;
        }

        $produk->update($data);

        return redirect()->route('produk.index')->with('success', 'Produk berhasil diperbarui!');
    }


    /**
     * Hapus produk
     */
    public function destroy($id)
    {
        $produk = Produk::findOrFail($id);

        if ($produk->image && file_exists(public_path($produk->image))) {
            unlink(public_path($produk->image));
        }

        $produk->delete();

        return redirect()->route('produk.index')->with('success', 'Produk berhasil dihapus!');
    }
}
