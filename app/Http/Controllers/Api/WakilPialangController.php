<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\KantorCabang;
use App\Models\WakilPialang;
use Illuminate\Http\Request;

class WakilPialangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = WakilPialang::query()->with('kantorCabang');

        if ($request->filled('kantor_cabang_id')) {
            $query->where('kantor_cabang_id', (int) $request->query('kantor_cabang_id'));
        }

        $wakilPialangs = $query->get();

        return response()->json([
            'status' => 200,
            'message' => 'Data Wakil Pialang berhasil diambil',
            'data' => $wakilPialangs,
        ], 200);
    }

    public function folders()
    {
        $folders = KantorCabang::query()
            ->select(['id', 'nama_kantor_cabang'])
            ->withCount('wakilPialangs')
            ->orderBy('nama_kantor_cabang')
            ->get();

        return response()->json([
            'status' => 200,
            'message' => 'Data folder cabang berhasil diambil',
            'data' => $folders,
        ], 200);
    }
}
