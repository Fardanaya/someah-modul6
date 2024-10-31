<?php

namespace App\Http\Controllers;

use App\Http\Resources\KategoriCollection;
use Illuminate\Http\Request;
use App\Models\Kategori;
use App\Http\Resources\KategoriResource;

class KategoriController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/kategori",
     *     tags={"Kategori"},
     *     summary="Ambil semua kategori",
     *     @OA\Response(
     *         response=200,
     *         description="Berhasil mengambil data kategori"
     *     )
     * )
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
            return successResponse(KategoriResource::collection($kategori), 'Data Kategori Berhasil Diambil');
        } catch (\Exception $e) {
            return errorResponse($e->getMessage(), 500);
        }
    }

    /**
     * @OA\Post(
     *     path="/api/kategori",
     *     tags={"Kategori"},
     *     summary="Buat kategori baru",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="nama_kategori", type="string", example="Elektronik"),
     *             @OA\Property(property="deskripsi", type="string", example="Barang elektronik")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Kategori berhasil dibuat"
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Data tidak valid"
     *     )
     * )
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama_kategori' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
        ]);

        try {
            $kategori = Kategori::create($validatedData);
            return successResponse(new KategoriResource($kategori), 'Kategori berhasil dibuat', 201);
        } catch (\Exception $e) {
            return errorResponse('Gagal membuat kategori', 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/kategori/{id}",
     *     tags={"Kategori"},
     *     summary="Ambil kategori berdasarkan ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID Kategori",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Data kategori ditemukan"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Kategori tidak ditemukan"
     *     )
     * )
     */
    public function show($id)
    {
        $kategori = Kategori::with('produk')->findOrFail($id);
        return new KategoriResource($kategori);
    }

    /**
     * @OA\Put(
     *     path="/api/kategori/{id}",
     *     tags={"Kategori"},
     *     summary="Perbarui kategori berdasarkan ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID Kategori",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="nama_kategori", type="string", example="Elektronik"),
     *             @OA\Property(property="deskripsi", type="string", example="Barang elektronik")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Kategori berhasil diperbarui"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Kategori tidak ditemukan"
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'nama_kategori' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
        ]);

        try {
            $kategori = Kategori::findOrFail($id);
            $kategori->update($validatedData);
            return successResponse(new KategoriResource($kategori), 'Kategori berhasil diupdate');
        } catch (\Exception $e) {
            return errorResponse('Gagal memperbarui kategori', 500);
        }
    }

    /**
     * @OA\Delete(
     *     path="/api/kategori/{id}",
     *     tags={"Kategori"},
     *     summary="Hapus kategori berdasarkan ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID Kategori",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Kategori berhasil dihapus"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Kategori tidak ditemukan"
     *     )
     * )
     */
    public function destroy($id)
    {
        try {
            $kategori = Kategori::findOrFail($id);
            $kategori->delete();
            return successResponse(null, 'Kategori berhasil dihapus');
            // } catch(ModelNotFoundException $e){
            //     return notFoundResponse('Kategori tidak ditemukan');
        } catch (\Exception $e) {
            return errorResponse('Gagal menghapus kategori', 500);
        }
    }
}
