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
        $tiktoks = TiktokLink::all()->map(function ($item) {
            $embed = (string) ($item->embed_code ?? '');
            $url = null;

            if ($embed !== '') {
                if (preg_match('/cite="([^"]+)"/i', $embed, $m)) {
                    $url = $m[1];
                } elseif (preg_match('#https?://www\.tiktok\.com/[^\\s"<>]+#i', $embed, $m)) {
                    $url = $m[0];
                }
            }

            return [
                'id' => $item->id,
                'title' => $item->title,
                'url' => $url,
                'created_at' => $item->created_at,
                'updated_at' => $item->updated_at,
            ];
        });

        return response()->json([
            'status' => 200,
            'message' => 'Data TikTok berhasil diambil',
            'data' => $tiktoks,
        ], 200);
    }
}
