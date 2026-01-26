<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\WakilPialang;
use Illuminate\Http\Request;

class WakilPialangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $WakilPialangs = wakilPialang::all();

        return response()->json([
            'status' => 200,
            'message' => 'Data Wakil Pialang berhasil diambil',
            'data' => $WakilPialangs,
        ], 200);
    }
}
