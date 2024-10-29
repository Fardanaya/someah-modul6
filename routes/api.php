<?php

use Illuminate\Support\Facades\Route;

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
use App\Http\Controllers\KategoriController;

Route::apiResource('/kategori', KategoriController::class);

use App\Http\Controllers\ProdukController;

Route::apiResource('/produk', ProdukController::class);
