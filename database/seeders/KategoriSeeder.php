<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Kategori;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Kategori::create(['nama_kategori' => 'Elektronik', 'deskripsi' => 'produk elektronik']);
        Kategori::create(['nama_kategori' => 'Fashion', 'deskripsi' => 'pakaian dan aksesoris']);
        Kategori::create(['nama_kategori' => 'Makanan', 'deskripsi' => 'produk makanan dan minuman']);
        Kategori::create(['nama_kategori' => 'Perlengkapan rumah', 'deskripsi' => 'perabotan dan alat rumah']);
        Kategori::create(['nama_kategori' => 'Olahraga', 'deskripsi' => 'peralatan olahraga']);
        Kategori::create(['nama_kategori' => 'Kesehatan', 'deskripsi' => 'produk kesehatan dan kebugaran']);
        Kategori::create(['nama_kategori' => 'Kecantikan', 'deskripsi' => 'produk kecantikan']);
        Kategori::create(['nama_kategori' => 'Buku', 'deskripsi' => 'buku dan alat tulis']);
        Kategori::create(['nama_kategori' => 'Mainan', 'deskripsi' => 'mainan anak-anak']);
        Kategori::create(['nama_kategori' => 'Otomotif', 'deskripsi' => 'produk otomotif']);
    }
}
