<?php

namespace App\Http\Controllers;

use App\Http\Resources\KategoriCollection;
use Illuminate\Http\Request;
use App\Models\Kategori;
use App\Http\Resources\KategoriResource;

class KategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // try {
        //     $kategori = Kategori::with('produk')->paginate(2);
        //     return successResponse(new KategoriCollection($kategori),  'Data Kategori Berhasil Diambil');
        // }catch(\Exception $e) {
        //     return errorResponse($e->getMessage(), 500);
        // }
        // DIUBAH CUMA AMBIL DATA KATEGORINYA TAMPA ADA PAGINATE (tujuan = nampilin di view buat selector kategori)
        try {
            $kategori = Kategori::all();
            return successResponse(KategoriResource::collection($kategori),  'Data Kategori Berhasil Diambil');
        }catch(\Exception $e) {
            return errorResponse($e->getMessage(), 500);
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
            'nama_kategori' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
        ]);

        try{
            $kategori = Kategori::create($validatedData);
            return successResponse(new KategoriResource($kategori), 'Kategori berhasil dibuat', 201);
        }catch(\Exception $e){
            return errorResponse('Gagal membuat kategori', 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $kategori = Kategori::with('produk')->findOrFail($id);
        return new KategoriResource($kategori);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'nama_kategori' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
        ]);

        try{
            $kategori = Kategori::findOrFail($id);
            $kategori->update($validatedData);
            return successResponse(new KategoriResource($kategori), 'Kategori berhasil diupdate');
        }catch(\Exception $e){
            return errorResponse('Gagal memperbarui kategori', 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $kategori = Kategori::findOrFail($id);
            $kategori->delete();
            return successResponse(null, 'Kategori berhasil dihapus');
        // } catch(ModelNotFoundException $e){
        //     return notFoundResponse('Kategori tidak ditemukan');
        } catch(\Exception $e){
            return errorResponse('Gagal menghapus kategori', 500);
        }
    }
}
