<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// KAMIS
// use App\Http\Controllers\ProdukController;

// // Route::apiResource hanya membuat route dasar API (index, store, show, update, destroy).
// // Route::resource membuat semua route (index, create, store, show, edit, update, destroy).
// // Gunakan apiResource untuk API-only, gunakan resource untuk aplikasi web dengan form.
// Route::apiResource('/produk', ProdukController::class);

// // tugas
// use App\Http\Controllers\CustomerController;

// Route::apiResource('/customer', CustomerController::class);

// //JUMAT
use App\Http\Controllers\KategoriControllerView;

Route::resource('/kategori', KategoriControllerView::class);

use App\Http\Controllers\ProdukControllerView;

Route::resource('/produk', ProdukControllerView::class);


