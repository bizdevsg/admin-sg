<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Setting;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $settings = Setting::query()
            ->select([
                'id',
                'web_title',
                'web_description',
                'address',
                'maps_link',
                'link_pengaduan',
                'phone',
                'fax',
                'email',
                'created_at',
                'updated_at',
            ])
            ->get();

        return response()->json([
            'status' => 200,
            'message' => 'Data Setting berhasil diambil',
            'data' => $settings,
        ], 200);
    }
}
