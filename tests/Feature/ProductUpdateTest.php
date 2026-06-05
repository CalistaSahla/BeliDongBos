<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Seller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Province;
use App\Models\City;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProductUpdateTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function test_update_produk_dengan_foto_baru_menghapus_foto_lama()
    {
        Storage::fake('public');

        $province = Province::create(['name' => 'Jawa Barat']);
        $city = City::create(['province_id' => $province->id, 'name' => 'Bandung']);
        $category = Category::create(['name' => 'Elektronik', 'slug' => 'elektronik']);

        $user = User::create([
            'name' => 'Seller Test',
            'email' => 'seller@test.com',
            'role' => 'seller',
            'password' => bcrypt('password123'),
        ]);

        $seller = Seller::create([
            'user_id' => $user->id,
            'nama_toko' => 'Toko Test',
            'nama_pic' => 'Seller Test',
            'kontak_pic' => '08123456789',
            'alamat_toko' => 'Jl. Test',
            'city_id' => $city->id,
            'province_id' => $province->id,
            'nomor_hp' => '08123456789',
            'email' => 'seller@test.com',
            'status' => 'approved',
            'is_active' => true,
        ]);

        // Simpan foto lama
        $oldPhoto = UploadedFile::fake()->create('old_foto.jpg', 100, 'image/jpeg');
        $oldPhotoPath = $oldPhoto->store('products', 'public');

        $product = Product::create([
            'seller_id' => $seller->id,
            'category_id' => $category->id,
            'nama_produk' => 'Produk Lama',
            'slug' => 'produk-lama-xxxxx',
            'deskripsi' => 'Deskripsi produk lama',
            'harga' => 100000,
            'stok' => 10,
            'kondisi' => 'baru',
            'foto_utama' => $oldPhotoPath,
        ]);

        Storage::disk('public')->assertExists($oldPhotoPath);

        // Upload foto baru
        $newPhoto = UploadedFile::fake()->create('new_foto.jpg', 100, 'image/jpeg');

        $response = $this->actingAs($user)->put("/seller/produk/{$product->id}", [
            'nama_produk' => 'Produk Update',
            'category_id' => $category->id,
            'deskripsi' => 'Deskripsi update',
            'harga' => 150000,
            'stok' => 20,
            'kondisi' => 'baru',
            'foto_utama' => $newPhoto,
        ]);

        $response->assertRedirect(route('seller.products.index'));

        // Foto lama terhapus dari storage
        Storage::disk('public')->assertMissing($oldPhotoPath);

        // Data di DB berubah
        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'nama_produk' => 'Produk Update',
            'harga' => 150000,
            'stok' => 20,
        ]);

        // Foto baru tersimpan
        $product->refresh();
        Storage::disk('public')->assertExists($product->foto_utama);
    }
}
