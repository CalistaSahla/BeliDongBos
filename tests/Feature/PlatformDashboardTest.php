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

class PlatformDashboardTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function test_dashboard_admin_menghitung_statistik_penjual_dan_produk()
    {
        $province = Province::create(['name' => 'Jawa Barat']);
        $city = City::create(['province_id' => $province->id, 'name' => 'Bandung']);
        $category = Category::create(['name' => 'Elektronik', 'slug' => 'elektronik']);

        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@belidongbos.com',
            'role' => 'platform',
            'password' => bcrypt('password123'),
        ]);

        // Buat 2 penjual: 1 aktif, 1 pending
        $sellerUser1 = User::create([
            'name' => 'Seller Aktif',
            'email' => 'aktif@test.com',
            'role' => 'seller',
            'password' => bcrypt('password123'),
        ]);
        $seller1 = Seller::create([
            'user_id' => $sellerUser1->id,
            'nama_toko' => 'Toko Aktif',
            'nama_pic' => 'Seller Aktif',
            'kontak_pic' => '081234',
            'alamat_toko' => 'Jl. Aktif',
            'city_id' => $city->id,
            'province_id' => $province->id,
            'nomor_hp' => '081234',
            'email' => 'aktif@test.com',
            'status' => 'approved',
            'is_active' => true,
        ]);

        $sellerUser2 = User::create([
            'name' => 'Seller Pending',
            'email' => 'pending@test.com',
            'role' => 'seller',
            'password' => bcrypt('password123'),
        ]);
        Seller::create([
            'user_id' => $sellerUser2->id,
            'nama_toko' => 'Toko Pending',
            'nama_pic' => 'Seller Pending',
            'kontak_pic' => '081235',
            'alamat_toko' => 'Jl. Pending',
            'city_id' => $city->id,
            'province_id' => $province->id,
            'nomor_hp' => '081235',
            'email' => 'pending@test.com',
            'status' => 'pending',
            'is_active' => false,
        ]);

        // Buat produk dan rating
        $product = Product::create([
            'seller_id' => $seller1->id,
            'category_id' => $category->id,
            'nama_produk' => 'Produk Test',
            'slug' => 'produk-test-abc12',
            'deskripsi' => 'Deskripsi',
            'harga' => 100000,
            'stok' => 10,
            'kondisi' => 'baru',
            'is_active' => true,
        ]);

        Rating::create([
            'product_id' => $product->id,
            'nama' => 'Reviewer',
            'nomor_hp' => '081234',
            'email' => 'reviewer@test.com',
            'rating' => 5,
            'komentar' => 'Bagus',
        ]);

        $response = $this->actingAs($admin)->get('/platform/dashboard');

        $response->assertStatus(200);
        $response->assertViewHas('stats');

        $stats = $response->viewData('stats');
        $this->assertEquals(2, $stats['total_sellers']);
        $this->assertEquals(1, $stats['active_sellers']);
        $this->assertEquals(1, $stats['pending_sellers']);
        $this->assertEquals(1, $stats['total_products']);
        $this->assertEquals(1, $stats['total_ratings']);
    }
}
