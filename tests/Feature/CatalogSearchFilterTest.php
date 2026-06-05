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

class CatalogSearchFilterTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function test_pencarian_dengan_keyword_dan_filter_kategori_dan_sorting()
    {
        $province = Province::create(['name' => 'Jawa Barat']);
        $city = City::create(['province_id' => $province->id, 'name' => 'Bandung']);
        $catElektronik = Category::create(['name' => 'Elektronik', 'slug' => 'elektronik']);
        $catFashion = Category::create(['name' => 'Fashion', 'slug' => 'fashion']);

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

        // Produk elektronik - harga mahal
        Product::create([
            'seller_id' => $seller->id,
            'category_id' => $catElektronik->id,
            'nama_produk' => 'Samsung Galaxy S24',
            'slug' => 'samsung-galaxy-s24-abc',
            'deskripsi' => 'HP Samsung terbaru',
            'harga' => 15000000,
            'stok' => 10,
            'kondisi' => 'baru',
            'is_active' => true,
        ]);

        // Produk elektronik - harga murah
        Product::create([
            'seller_id' => $seller->id,
            'category_id' => $catElektronik->id,
            'nama_produk' => 'Samsung Charger',
            'slug' => 'samsung-charger-abc',
            'deskripsi' => 'Charger Samsung original',
            'harga' => 200000,
            'stok' => 50,
            'kondisi' => 'baru',
            'is_active' => true,
        ]);

        // Produk fashion (tidak boleh muncul saat filter elektronik)
        Product::create([
            'seller_id' => $seller->id,
            'category_id' => $catFashion->id,
            'nama_produk' => 'Kaos Samsung Fan',
            'slug' => 'kaos-samsung-fan-abc',
            'deskripsi' => 'Kaos fans Samsung',
            'harga' => 100000,
            'stok' => 100,
            'kondisi' => 'baru',
            'is_active' => true,
        ]);

        // Search "Samsung" + filter kategori Elektronik + sort harga terendah
        $response = $this->get('/katalog?' . http_build_query([
            'search' => 'Samsung',
            'category_id' => $catElektronik->id,
            'sort' => 'price_low',
        ]));

        $response->assertStatus(200);
        $response->assertSee('Samsung Galaxy S24');
        $response->assertSee('Samsung Charger');
        $response->assertDontSee('Kaos Samsung Fan');

        // Verifikasi urutan: charger (200rb) harus sebelum galaxy (15jt)
        $products = $response->viewData('products');
        $this->assertTrue($products[0]->harga <= $products[1]->harga);
    }
}
