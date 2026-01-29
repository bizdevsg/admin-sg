<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Import semua controller yang dipakai
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HandlingController;
use App\Http\Controllers\KantorCabangController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\WakilPialangController;
use App\Http\Controllers\LegalitasController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application.
|
*/

// Authentication routes
Auth::routes(['register' => false]);

// Home Page Routes
Route::get('/', [HomeController::class, 'index'])->name('home');

// Produk Page Routes
Route::prefix('produk')->group(function () {
    Route::get('/', [ProdukController::class, 'index'])->name('produk.index');
    Route::get('/create', [ProdukController::class, 'create'])->name('produk.create');
    Route::post('/store', [ProdukController::class, 'store'])->name('produk.store');
    Route::get('/{id}/edit', [ProdukController::class, 'edit'])->name('produk.edit');
    Route::put('/{id}', [ProdukController::class, 'update'])->name('produk.update');
    Route::delete('/{id}', [ProdukController::class, 'destroy'])->name('produk.destroy');
    Route::get('/{slug}', [ProdukController::class, 'show'])->name('produk.show');
});

// Video Page Routes
Route::get('/video', [VideoController::class, 'index'])->name('video.index');
Route::post('/video', [VideoController::class, 'store'])->name('video.store');
Route::get('/video/create', [VideoController::class, 'create'])->name('video.create');
Route::get('/video/edit/{id}', [VideoController::class, 'edit'])->name('video.edit');
Route::put('/video/edit/put/{id}', [VideoController::class, 'update'])->name('video.update');
Route::delete('/video/delete/{id}', [VideoController::class, 'destroy'])->name('video.destroy');
Route::delete('/video/delete', [VideoController::class, 'bulkDelete'])->name('video.bulkDelete');

// Profile Routes
Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

// User Management Routes (Superadmin only)
Route::middleware('role:superadmin')->group(function () {
    Route::get('/users', [UserController::class, 'index'])->name('user.index');
    Route::post('/users', [UserController::class, 'store'])->name('user.store');
    Route::get('/users/create', [UserController::class, 'create'])->name('user.create');
    Route::put('/users/edit/put/{id}', [UserController::class, 'update'])->name('user.update');
    Route::get('/users/edit/{id}', [UserController::class, 'edit'])->name('user.edit');
    Route::delete('/users/delete/{id}', [UserController::class, 'destroy'])->name('user.destroy');
});

// Settings Route
Route::prefix('settings')->name('settings.')->group(function () {
    Route::get('/',            [SettingController::class, 'index'])->name('index');
    Route::post('/',           [SettingController::class, 'store'])->name('store');
    Route::get('/{id}/edit',   [SettingController::class, 'edit'])->name('edit');
    Route::put('/{id}',        [SettingController::class, 'update'])->name('update');
    Route::delete('/{id}',     [SettingController::class, 'destroy'])->name('destroy');
});

Route::prefix('kantor-cabang')->name('kantor-cabang.')->middleware('auth')->group(function () {
    Route::get('/', [KantorCabangController::class, 'index'])->name('index');
    Route::get('/create', [KantorCabangController::class, 'create'])->name('create');
    Route::post('/', [KantorCabangController::class, 'store'])->name('store');
    Route::get('/{id}/edit', [KantorCabangController::class, 'edit'])->name('edit');
    Route::put('/{id}', [KantorCabangController::class, 'update'])->name('update');
    Route::delete('/{id}', [KantorCabangController::class, 'destroy'])->name('destroy');
});

Route::prefix('wakil-pialang')->name('wakil-pialang.')->middleware('auth')->group(function () {
    Route::get('/',          [WakilPialangController::class, 'index'])->name('index');
    Route::get('/create',    [WakilPialangController::class, 'create'])->name('create');
    Route::post('/',         [WakilPialangController::class, 'store'])->name('store');
    Route::get('/{id}/edit', [WakilPialangController::class, 'edit'])->name('edit');
    Route::put('/{id}',      [WakilPialangController::class, 'update'])->name('update');
    Route::delete('/{id}',   [WakilPialangController::class, 'destroy'])->name('destroy');
});

Route::prefix('legalitas')->name('legalitas.')->middleware('auth')->group(function () {
    Route::get('/',          [LegalitasController::class, 'index'])->name('index');
    Route::get('/create',    [LegalitasController::class, 'create'])->name('create');
    Route::post('/',         [LegalitasController::class, 'store'])->name('store');
    Route::get('/{id}/edit', [LegalitasController::class, 'edit'])->name('edit');
    Route::put('/{id}',      [LegalitasController::class, 'update'])->name('update');
    Route::delete('/{id}',   [LegalitasController::class, 'destroy'])->name('destroy');
});

// Routes Handling Errors
Route::get('/404', [HandlingController::class, 'Error404'])->name('404');
Route::get('/403', [HandlingController::class, 'Error403'])->name('403');
