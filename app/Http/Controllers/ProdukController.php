<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProdukCollection;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Models\Produk;
use App\Http\Resources\ProdukResource;

class ProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    
    public function index()
    {
        // $produks = Produk::with('kategori')->get();
        // return ProdukResource::collection($produks);

        // Kamis
        // $produks = Produk::all();
        // return new ProdukCollection($produks);

        // Jumat
        // $produks = Produk::paginate(10);
        // return new ProdukCollection($produks);
        try {
            $produks = Produk::with('kategori')->paginate(10);
            return successResponse(new ProdukCollection($produks), 'Produk berhasil diambil', 200);
        } catch(\Exception $e) {
            return errorResponse(null, 'Produk tidak ditemukan', 404);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama_produk' => 'required|string|max:255',
            'harga' => 'required|numeric',
            'deskripsi' => 'nullable|string',
            'kategori_id' => 'required|exists:kategoris,id',
        ]);

        try {
            $produk = Produk::create($validatedData);
            return successResponse(new ProdukResource($produk), 'Produk berhasil dibuat', 201);
        } catch (\Exception $e) {
            return errorResponse('Gagal membuat produk', 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $produk = Produk::with('kategori')->findOrFail($id);
            return new ProdukResource($produk);
        } catch(\Exception $e){
            return errorResponse(null, 'Produk tidak ditemukan', 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'nama_produk' => 'required|string|max:255',
            'harga' => 'required|numeric',
            'deskripsi' => 'nullable|string',
            'kategori_id' => 'required|exists:kategoris,id',
        ]);

        try {
            $produk = Produk::findOrFail($id);
            $produk->update($validatedData);
            return successResponse(new ProdukResource($produk), 'Produk berhasil diperbarui', 201);
        } catch(\Exception $e) {
            return errorResponse('Gagal memperbarui produk', 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $produk = Produk::findOrFail($id);
            $produk->delete();
            return successResponse(null, 'Produk berhasil dihapus');
        } catch(ModelNotFoundException $e) {
            return notFoundResponse('Produk tidak ditemukan');
        } catch(\Exception $e) {
            return errorResponse('Gagal memperbarui produk', 500);
        }
    }
}
