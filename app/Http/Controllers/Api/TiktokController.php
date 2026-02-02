<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TiktokLink;

class TiktokController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tiktoks = TiktokLink::all();

        return response()->json([
            'status' => 200,
            'message' => 'Data TikTok berhasil diambil',
            'data' => $tiktoks,
        ], 200);
    }
}
