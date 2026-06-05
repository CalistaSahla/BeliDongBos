<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Seller;
use App\Models\Province;
use App\Models\City;
use App\Mail\SellerApproved;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class SellerApprovalTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function test_admin_approve_seller_pending_mengubah_status_dan_kirim_email()
    {
        Mail::fake();

        $province = Province::create(['name' => 'Jawa Barat']);
        $city = City::create(['province_id' => $province->id, 'name' => 'Bandung']);

        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@belidongbos.com',
            'role' => 'platform',
            'password' => bcrypt('password123'),
        ]);

        $sellerUser = User::create([
            'name' => 'Penjual Baru',
            'email' => 'penjual@test.com',
            'role' => 'seller',
            'password' => bcrypt('password123'),
        ]);

        $seller = Seller::create([
            'user_id' => $sellerUser->id,
            'nama_toko' => 'Toko Baru',
            'nama_pic' => 'Penjual Baru',
            'kontak_pic' => '08123456789',
            'alamat_toko' => 'Jl. Test',
            'city_id' => $city->id,
            'province_id' => $province->id,
            'nomor_hp' => '08123456789',
            'email' => 'penjual@test.com',
            'status' => 'pending',
            'is_active' => false,
        ]);

        $response = $this->actingAs($admin)->post("/platform/penjual/{$seller->id}/approve");

        $response->assertRedirect(route('platform.pending-sellers'));

        $this->assertDatabaseHas('sellers', [
            'id' => $seller->id,
            'status' => 'approved',
        ]);

        $seller->refresh();
        $this->assertNotNull($seller->activation_token);

        Mail::assertSent(SellerApproved::class, function ($mail) {
            return $mail->hasTo('penjual@test.com');
        });
    }
}
