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

class RatingDuplicateTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function test_rating_duplikat_email_pada_produk_yang_sama_ditolak()
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
            'nama_produk' => 'Produk Test',
            'slug' => 'produk-test-abc12',
            'deskripsi' => 'Deskripsi test',
            'harga' => 100000,
            'stok' => 10,
            'kondisi' => 'baru',
            'is_active' => true,
        ]);

        // Rating pertama sudah ada
        Rating::create([
            'product_id' => $product->id,
            'nama' => 'User Pertama',
            'nomor_hp' => '08111111111',
            'email' => 'duplikat@test.com',
            'rating' => 4,
            'komentar' => 'Bagus sekali',
        ]);

        // Coba kirim rating kedua dengan email yang sama
        $response = $this->post("/produk/{$product->id}/ulasan", [
            'nama' => 'User Kedua',
            'nomor_hp' => '08222222222',
            'email' => 'duplikat@test.com',
            'rating' => 5,
            'komentar' => 'Mantap',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('error', 'Email ini sudah pernah memberikan ulasan untuk produk ini.');

        // Pastikan rating kedua tidak tersimpan
        $this->assertEquals(1, Rating::where('product_id', $product->id)->count());
    }
}
