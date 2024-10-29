<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Produk;
use App\Models\Kategori;

class ProdukSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kategoris = Kategori::whereIn('nama_kategori', [
            'Elektronik', 
            'Fashion', 
            'Makanan', 
            'Perlengkapan rumah', 
            'Olahraga', 
            'Kesehatan', 
            'Kecantikan'
        ])->pluck('id', 'nama_kategori');

        Produk::create(['nama_produk' => 'Laptop', 'harga' => 10000000, 'deskripsi' => 'Laptop untuk kebutuhan kerja', 'kategori_id' => $kategoris['Elektronik']]);
        Produk::create(['nama_produk' => 'Smartphone', 'harga' => 5000000, 'deskripsi' => 'Smartphone Android terbaru', 'kategori_id' => $kategoris['Elektronik']]);
        Produk::create(['nama_produk' => 'Kaos', 'harga' => 100000, 'deskripsi' => 'Kaos polos berbagai warna', 'kategori_id' => $kategoris['Fashion']]);
        Produk::create(['nama_produk' => 'Celana Jeans', 'harga' => 200000, 'deskripsi' => 'Celana jeans pria', 'kategori_id' => $kategoris['Fashion']]);
        Produk::create(['nama_produk' => 'Mie Instan', 'harga' => 5000, 'deskripsi' => 'Makanan instan cepat saji', 'kategori_id' => $kategoris['Makanan']]);
        Produk::create(['nama_produk' => 'Air Mineral', 'harga' => 3000, 'deskripsi' => 'Air minum dalam kemasan', 'kategori_id' => $kategoris['Makanan']]);
        Produk::create(['nama_produk' => 'Sofa', 'harga' => 1500000, 'deskripsi' => 'Sofa minimalis modern', 'kategori_id' => $kategoris['Perlengkapan rumah']]);
        Produk::create(['nama_produk' => 'Sepatu olahraga', 'harga' => 300000, 'deskripsi' => 'Sepatu untuk aktivitas olahraga', 'kategori_id' => $kategoris['Olahraga']]);
        Produk::create(['nama_produk' => 'Multivitamin', 'harga' => 100000, 'deskripsi' => 'Suplemen multivitamin harian', 'kategori_id' => $kategoris['Kesehatan']]);
        Produk::create(['nama_produk' => 'Shampoo', 'harga' => 25000, 'deskripsi' => 'Shampoo untuk perawatan rambut', 'kategori_id' => $kategoris['Kecantikan']]);
    }
}
