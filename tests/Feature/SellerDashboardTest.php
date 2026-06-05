<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Seller;
use App\Models\Product;
use App\Models\Rating;
use App\Models\Category;
use App\Models\Province;
use App\Models\City;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SellerDashboardTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function test_dashboard_penjual_menampilkan_statistik_milik_sendiri()
    {
        $province = Province::create(['name' => 'Jawa Barat']);
        $city = City::create(['province_id' => $province->id, 'name' => 'Bandung']);
        $category = Category::create(['name' => 'Elektronik', 'slug' => 'elektronik']);

        // Penjual 1 (yang login)
        $user1 = User::create([
            'name' => 'Seller 1',
            'email' => 'seller1@test.com',
            'role' => 'seller',
            'password' => bcrypt('password123'),
        ]);
        $seller1 = Seller::create([
            'user_id' => $user1->id,
            'nama_toko' => 'Toko Seller 1',
            'nama_pic' => 'Seller 1',
            'kontak_pic' => '081234',
            'alamat_toko' => 'Jl. Test 1',
            'city_id' => $city->id,
            'province_id' => $province->id,
            'nomor_hp' => '081234',
            'email' => 'seller1@test.com',
            'status' => 'approved',
            'is_active' => true,
        ]);

        // Penjual 2 (penjual lain)
        $user2 = User::create([
            'name' => 'Seller 2',
            'email' => 'seller2@test.com',
            'role' => 'seller',
            'password' => bcrypt('password123'),
        ]);
        $seller2 = Seller::create([
            'user_id' => $user2->id,
            'nama_toko' => 'Toko Seller 2',
            'nama_pic' => 'Seller 2',
            'kontak_pic' => '081235',
            'alamat_toko' => 'Jl. Test 2',
            'city_id' => $city->id,
            'province_id' => $province->id,
            'nomor_hp' => '081235',
            'email' => 'seller2@test.com',
            'status' => 'approved',
            'is_active' => true,
        ]);

        // Produk milik seller1: 2 produk, stok total 15
        Product::create([
            'seller_id' => $seller1->id,
            'category_id' => $category->id,
            'nama_produk' => 'Produk A',
            'slug' => 'produk-a-abc12',
            'deskripsi' => 'Deskripsi A',
            'harga' => 100000,
            'stok' => 10,
            'kondisi' => 'baru',
            'is_active' => true,
        ]);
        Product::create([
            'seller_id' => $seller1->id,
            'category_id' => $category->id,
            'nama_produk' => 'Produk B',
            'slug' => 'produk-b-abc12',
            'deskripsi' => 'Deskripsi B',
            'harga' => 50000,
            'stok' => 5,
            'kondisi' => 'baru',
            'is_active' => true,
        ]);

        // Produk milik seller2 (tidak boleh terhitung)
        Product::create([
            'seller_id' => $seller2->id,
            'category_id' => $category->id,
            'nama_produk' => 'Produk Lain',
            'slug' => 'produk-lain-abc12',
            'deskripsi' => 'Deskripsi Lain',
            'harga' => 200000,
            'stok' => 100,
            'kondisi' => 'baru',
            'is_active' => true,
        ]);

        $response = $this->actingAs($user1)->get('/seller/dashboard');

        $response->assertStatus(200);
        $response->assertViewHas('stats');

        $stats = $response->viewData('stats');
        $this->assertEquals(2, $stats['total_products']);
        $this->assertEquals(15, $stats['total_stock']);
    }
}
