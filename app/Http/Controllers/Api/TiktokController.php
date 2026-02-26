<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TiktokLink;
use Illuminate\Support\Facades\Storage;

class TiktokController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tiktoks = TiktokLink::latest()->get()->map(function ($tiktok) {
            return [
                'id' => $tiktok->id,
                'title' => $tiktok->title,
                'embed_code' => $tiktok->embed_code,
                'backup_video_url' => $tiktok->backup_video_path
                    ? Storage::url($tiktok->backup_video_path)
                    : null,
                'created_at' => $tiktok->created_at,
                'updated_at' => $tiktok->updated_at,
            ];
        });

        return response()->json([
            'status' => 200,
            'message' => 'Data TikTok berhasil diambil',
            'data' => $tiktoks,
        ], 200);
    }
}
