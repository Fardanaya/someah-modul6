<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\KategoriController;
use App\Http\Middleware\CustomJWTMiddleware;
Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);
Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:api');
Route::middleware([CustomJWTMiddleware::class])->group(function () {
    Route::apiResource('kategori', KategoriController::class);
});



// KAMIS
// use App\Http\Controllers\ProdukController;

// Route::apiResource hanya membuat route dasar API (index, store, show, update, destroy).
// Route::resource membuat semua route (index, create, store, show, edit, update, destroy).
// Gunakan apiResource untuk API-only, gunakan resource untuk aplikasi web dengan form.
// Route::apiResource('/produk', ProdukController::class);

// tugas
use App\Http\Controllers\CustomerController;

Route::apiResource('/customer', CustomerController::class);

//JUMAT
// use App\Http\Controllers\KategoriController;

// Route::apiResource('/kategori', KategoriController::class);

use App\Http\Controllers\ProdukController;

Route::get('/produk/search', [ProdukController::class, 'search']);
Route::get('/produk/filterHarga', [ProdukController::class,  'filterHarga']);
Route::apiResource('/produk', ProdukController::class);

