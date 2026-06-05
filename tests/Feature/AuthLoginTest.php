<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Seller;
use App\Models\Province;
use App\Models\City;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthLoginTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function test_login_seller_terverifikasi_redirect_ke_seller_dashboard()
    {
        $province = Province::create(['name' => 'Jawa Barat']);
        $city = City::create(['province_id' => $province->id, 'name' => 'Bandung']);

        $user = User::create([
            'name' => 'Test Seller',
            'email' => 'seller@test.com',
            'role' => 'seller',
            'password' => bcrypt('password123'),
        ]);

        Seller::create([
            'user_id' => $user->id,
            'nama_toko' => 'Toko Test',
            'nama_pic' => 'Test Seller',
            'kontak_pic' => '08123456789',
            'alamat_toko' => 'Jl. Test',
            'city_id' => $city->id,
            'province_id' => $province->id,
            'nomor_hp' => '08123456789',
            'email' => 'seller@test.com',
            'status' => 'approved',
            'is_active' => true,
        ]);

        $response = $this->post('/login', [
            'email' => 'seller@test.com',
            'password' => 'password123',
        ]);

        $response->assertRedirect('/seller/dashboard');
        $this->assertAuthenticatedAs($user);
    }
}
