<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProdukCollection;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Models\Produk;
use App\Http\Resources\ProdukResource;


class ProdukController extends Controller
{
    // INDEX
    /**
     * @OA\Get(
     *     path="/api/produk",
     *     tags={"Produk"},
     *     summary="Mendapatkan semua data produk",
     *     @OA\Response(
     *         response=200,
     *         description="Berhasil mengambil data kategori"
     *     )
     * )
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
            $produks = Produk::with('kategori')->paginate(20);
            return successResponse(new ProdukCollection($produks), 'Produk berhasil diambil', 200);
        } catch(\Exception $e) {
            return errorResponse(null, 'Produk tidak ditemukan', 404);
        }
    }

    // STORE
    /**
     * @OA\Post(
     *     path="/api/produk",
     *     tags={"Produk"},
     *     summary="Menambahkan produk baru",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="nama_produk", type="string", example="Laptop"),
     *             @OA\Property(property="harga", type="number", format="float", example=15000000),
     *             @OA\Property(property="deskripsi", type="string", example="Laptop gaming"),
     *             @OA\Property(property="kategori_id", type="string", format="uuid")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Produk berhasil dibuat",
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Data yang dikirim tidak valid"
     *     )
     * )
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


    // SHOW BY ID
    /**
     * @OA\Get(
     *     path="/api/produk/{id}",
     *     tags={"Produk"},
     *     summary="Mendapatkan detail produk berdasarkan ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID Produk",
     *         @OA\Schema(type="string", format="uuid")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Detail produk ditemukan",
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Produk tidak ditemukan"
     *     )
     * )
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

    // UPDATE
    /**
     * @OA\Put(
     *     path="/api/produk/{id}",
     *     tags={"Produk"},
     *     summary="Memperbarui produk berdasarkan ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID Produk",
     *         @OA\Schema(type="string", format="uuid")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="nama_produk", type="string", example="Laptop"),
     *             @OA\Property(property="harga", type="number", format="float", example=15000000),
     *             @OA\Property(property="deskripsi", type="string", example="Laptop gaming"),
     *             @OA\Property(property="kategori_id", type="string", format="uuid")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Produk berhasil diperbarui",
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Produk tidak ditemukan"
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Data yang dikirim tidak valid"
     *     )
     * )
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

    // DELETE
    /**
     * @OA\Delete(
     *     path="/api/produk/{id}",
     *     tags={"Produk"},
     *     summary="Menghapus produk berdasarkan ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID Produk",
     *         @OA\Schema(type="string", format="uuid")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Produk berhasil dihapus"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Produk tidak ditemukan"
     *     )
     * )
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

    // GET WITH PRICE MIN
    /**
     * @OA\Get(
     *     path="/api/produk/moreThan",
     *     tags={"Produk"},
     *     summary="Mendapatkan produk dengan harga lebih dari threshold",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="threshold", type="number", example=100000),
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Produk berhasil ditemukan",
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Produk tidak ditemukan"
     *     )
     * )
     */
    public function moreThan(Request $request) {
        try {
            $threshold = $request->input('threshold');
            $produk = Produk::where('harga',  '>', $threshold)->paginate(10);
            return successResponse(new ProdukCollection($produk), "Produk dengan harga lebih dari ". $threshold . " berhasil ditemukan", 200);
        } catch(\Exception $e) {
            return  errorResponse('Gagal mengambil data produk', $e->getMessage());
        }
    }

    // SEARCH BY PRODUCT NAME
    /**
     * @OA\Get(
     *     path="/api/produk/search",
     *     tags={"Produk"},
     *     summary="Mencari produk berdasarkan nama",
     *     @OA\Parameter(
     *         name="nama_produk",
     *         in="query",
     *         required=true,
     *         description="Nama produk yang dicari",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Produk berhasil ditemukan",
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Produk tidak ditemukan"
     *     )
     * )
     */
    public function search(Request $request) {
        // Implementasi pencarian produk berdasarkan nama
        $request->validate(['nama_produk' => 'required|string']);
        $nama_produk = $request->query('nama_produk');
        $produk = Produk::where('nama_produk', 'like', '%' . $nama_produk . '%')->paginate(10);
        
        if ($produk->isEmpty()) {
            return errorResponse(null, 'Produk tidak ditemukan', 404);
        }
        
        return successResponse(new ProdukCollection($produk), 'Produk berhasil ditemukan', 200);
    }
}
