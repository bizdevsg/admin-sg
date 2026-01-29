<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Import controller API (ubah namespace sesuai struktur kamu)
use App\Http\Controllers\Api\BeritaController;
use App\Http\Controllers\Api\VideoController;
use App\Http\Controllers\Api\BannerController;
use App\Http\Controllers\Api\KantorCabangController;
use App\Http\Controllers\Api\LegalitasController;
use App\Http\Controllers\Api\ProdukController;
use App\Http\Controllers\Api\SettingController;
use App\Http\Controllers\Api\WakilPialangController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// Contoh endpoint user jika pakai Sanctum
// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::prefix('v1')->group(function () {

    // ===== Berita =====
    Route::get('/berita',           [BeritaController::class, 'index']);              // semua berita
    Route::get('/berita/{id}',      [BeritaController::class, 'showById']);           // by id, ex: /v1/berita/123
    Route::get('/berita/judul/{q}', [BeritaController::class, 'showByTitle']);        // by title/slug, ex: /v1/berita/judul/investasi-aman

    // ===== Video =====
    Route::get('/video',            [VideoController::class, 'index']);

    // ===== Banner =====
    Route::get('/banner',           [BannerController::class, 'index']);

    // ===== Produk =====
    Route::get('/produk',           [ProdukController::class, 'index']);

    // ===== Setting =====
    Route::get('/setting',          [SettingController::class, 'index']);

    // ===== Legalitas =====
    Route::get('/legalitas',    [LegalitasController::class, 'index']);

	    // ===== Wakil Pialang =====
	    Route::get('/wakil-pialang/folders', [WakilPialangController::class, 'folders']);
	    Route::get('/wakil-pialang',    [WakilPialangController::class, 'index']);

	    // ===== kantor Cabang =====
	    Route::get('/kantor-cabang',    [KantorCabangController::class, 'index']);
	});
