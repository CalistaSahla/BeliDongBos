<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Seller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Province;
use App\Models\City;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CatalogShowTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function test_halaman_detail_produk_aktif_dari_penjual_terverifikasi()
    {
        $province = Province::create(['name' => 'Jawa Barat']);
        $city = City::create(['province_id' => $province->id, 'name' => 'Bandung']);
        $category = Category::create(['name' => 'Elektronik', 'slug' => 'elektronik']);

        $user = User::create([
            'name' => 'Seller',
            'email' => 'seller@test.com',
            'role' => 'seller',
            'password' => bcrypt('password123'),
        ]);

        $seller = Seller::create([
            'user_id' => $user->id,
            'nama_toko' => 'Toko Test',
            'nama_pic' => 'Seller',
            'kontak_pic' => '081234',
            'alamat_toko' => 'Jl. Test',
            'city_id' => $city->id,
            'province_id' => $province->id,
            'nomor_hp' => '081234',
            'email' => 'seller@test.com',
            'status' => 'approved',
            'is_active' => true,
        ]);

        $product = Product::create([
            'seller_id' => $seller->id,
            'category_id' => $category->id,
            'nama_produk' => 'Laptop Test',
            'slug' => 'laptop-test-abc12',
            'deskripsi' => 'Deskripsi laptop test',
            'harga' => 5000000,
            'stok' => 5,
            'kondisi' => 'baru',
            'is_active' => true,
        ]);

        $response = $this->get("/produk/{$product->slug}");

        $response->assertStatus(200);
        $response->assertViewHas('product');
        $response->assertViewHas('relatedProducts');
        $response->assertSee('Laptop Test');
        $response->assertSee('Toko Test');
    }
}
