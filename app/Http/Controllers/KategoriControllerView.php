<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KategoriControllerView extends Controller
{
    public function index(Request $request) {
        // if ($request->ajax()) {
        //     $kategori = Kategori::with('produk')->get();
        //     return Database::of($kategori)
        //     ->addIndexColumn()
        //     ->make(True);
        // }
        return view('kategori.index');
    }
}
