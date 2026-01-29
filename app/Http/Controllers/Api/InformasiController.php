<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Informasi;

class InformasiController extends Controller
{
    public function index()
    {
        $informasi = Informasi::query()
            ->orderByDesc('created_at')
            ->get();

        return response()->json([
            'status'  => 200,
            'message' => 'Data Informasi berhasil diambil',
            'data'    => $informasi,
        ], 200);
    }

    public function show(string $slug)
    {
        $informasi = Informasi::where('slug', $slug)->first();

        if (! $informasi) {
            return response()->json([
                'status'  => 404,
                'message' => 'Informasi tidak ditemukan',
                'data'    => null,
            ], 404);
        }

        return response()->json([
            'status'  => 200,
            'message' => 'Detail Informasi berhasil diambil',
            'data'    => $informasi,
        ], 200);
    }
}
