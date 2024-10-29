<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProdukControllerView extends Controller
{
    public function index(Request $request) {
        return view('produk.index');
    }
}
