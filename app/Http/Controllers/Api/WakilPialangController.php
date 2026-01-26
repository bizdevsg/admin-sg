<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\KantorCabang;
use App\Models\Setting;
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
            $kantorCabangId = (int) $request->query('kantor_cabang_id');
            if ($kantorCabangId === 0) {
                $query->whereNull('kantor_cabang_id');
            } else {
                $query->where('kantor_cabang_id', $kantorCabangId);
            }
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
        $setting = Setting::query()->first();
        $kantorPusatLabel = $setting?->web_title ? "Kantor Pusat - {$setting->web_title}" : 'Kantor Pusat';

        $kantorPusat = [
            'id' => 0,
            'nama_kantor_cabang' => $kantorPusatLabel,
            'wakil_pialangs_count' => WakilPialang::query()->whereNull('kantor_cabang_id')->count(),
            'address' => $setting?->address,
            'phone' => $setting?->phone,
            'email' => $setting?->email,
            'is_pusat' => true,
        ];

        $folders = KantorCabang::query()
            ->select(['id', 'nama_kantor_cabang'])
            ->withCount('wakilPialangs')
            ->orderBy('nama_kantor_cabang')
            ->get();

        $folders = $folders
            ->map(function ($folder) {
                $folder->is_pusat = false;
                return $folder;
            })
            ->prepend($kantorPusat)
            ->values();

        return response()->json([
            'status' => 200,
            'message' => 'Data folder cabang berhasil diambil',
            'data' => $folders,
        ], 200);
    }
}
