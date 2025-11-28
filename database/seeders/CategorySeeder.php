<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Elektronik', 'description' => 'Produk elektronik seperti HP, laptop, TV, dll'],
            ['name' => 'Fashion Pria', 'description' => 'Pakaian dan aksesoris pria'],
            ['name' => 'Fashion Wanita', 'description' => 'Pakaian dan aksesoris wanita'],
            ['name' => 'Makanan & Minuman', 'description' => 'Produk makanan dan minuman'],
            ['name' => 'Kesehatan', 'description' => 'Produk kesehatan dan obat-obatan'],
            ['name' => 'Kecantikan', 'description' => 'Produk kecantikan dan perawatan tubuh'],
            ['name' => 'Rumah Tangga', 'description' => 'Peralatan rumah tangga'],
            ['name' => 'Olahraga', 'description' => 'Peralatan dan perlengkapan olahraga'],
            ['name' => 'Otomotif', 'description' => 'Aksesoris dan sparepart kendaraan'],
            ['name' => 'Hobi & Koleksi', 'description' => 'Produk hobi dan barang koleksi'],
            ['name' => 'Buku & Alat Tulis', 'description' => 'Buku dan perlengkapan tulis'],
            ['name' => 'Ibu & Bayi', 'description' => 'Produk untuk ibu dan bayi'],
            ['name' => 'Komputer & Laptop', 'description' => 'Komputer, laptop, dan aksesorisnya'],
            ['name' => 'Handphone & Tablet', 'description' => 'HP, tablet, dan aksesorisnya'],
            ['name' => 'Perawatan Hewan', 'description' => 'Produk untuk hewan peliharaan'],
        ];

        foreach ($categories as $category) {

            // Tambahkan slug
            $category['slug'] = Str::slug($category['name']);

            Category::create($category);
        }
    }
}
