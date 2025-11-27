<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Seller;
use App\Models\City;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SellerSeeder extends Seeder
{
    public function run(): void
    {
        $sellers = [
            [
                'user' => ['name' => 'Calista Aurelia', 'email' => 'calista@calistastore.com'],
                'seller' => [
                    'nama_toko' => 'Calista Gadget Store',
                    'nama_pic' => 'Calista Aurelia',
                    'kontak_pic' => '081234567890',
                    'alamat_toko' => 'Jl. Mangga Dua No. 123, Jakarta Pusat',
                    'city_id' => 1,
                    'province_id' => 11,
                    'nomor_hp' => '081234567890',
                    'email' => 'calista@calistastore.com',
                ],
            ],
            [
                'user' => ['name' => 'Aninditya Putri', 'email' => 'aninditya@aninfashion.com'],
                'seller' => [
                    'nama_toko' => 'Aninditya Fashion House',
                    'nama_pic' => 'Aninditya Putri',
                    'kontak_pic' => '082345678901',
                    'alamat_toko' => 'Jl. Braga No. 45, Bandung',
                    'city_id' => 6,
                    'province_id' => 12,
                    'nomor_hp' => '082345678901',
                    'email' => 'aninditya@aninfashion.com',
                ],
            ],
            [
                'user' => ['name' => 'Angelica Dewi', 'email' => 'angelica@angelicashop.com'],
                'seller' => [
                    'nama_toko' => 'Angelica Beauty Shop',
                    'nama_pic' => 'Angelica Dewi',
                    'kontak_pic' => '083456789012',
                    'alamat_toko' => 'Jl. Tunjungan No. 78, Surabaya',
                    'city_id' => 23,
                    'province_id' => 15,
                    'nomor_hp' => '083456789012',
                    'email' => 'angelica@angelicashop.com',
                ],
            ],
            [
                'user' => ['name' => 'Miranda Salsabila', 'email' => 'miranda@mirandamart.com'],
                'seller' => [
                    'nama_toko' => 'Miranda Home & Living',
                    'nama_pic' => 'Miranda Salsabila',
                    'kontak_pic' => '084567890123',
                    'alamat_toko' => 'Jl. Malioboro No. 12, Yogyakarta',
                    'city_id' => 22,
                    'province_id' => 14,
                    'nomor_hp' => '084567890123',
                    'email' => 'miranda@mirandamart.com',
                ],
            ],
            [
                'user' => ['name' => 'Keisha Nathania', 'email' => 'keisha@keishasport.com'],
                'seller' => [
                    'nama_toko' => 'Keisha Sport & Hobby',
                    'nama_pic' => 'Keisha Nathania',
                    'kontak_pic' => '085678901234',
                    'alamat_toko' => 'Jl. Asia Afrika No. 56, Bandung',
                    'city_id' => 6,
                    'province_id' => 12,
                    'nomor_hp' => '085678901234',
                    'email' => 'keisha@keishasport.com',
                ],
            ],
        ];

        foreach ($sellers as $data) {
            $user = User::create([
                'name' => $data['user']['name'],
                'email' => $data['user']['email'],
                'role' => 'seller',
                'password' => Hash::make('password123'),
                'email_verified_at' => now(),
            ]);

            Seller::create(array_merge($data['seller'], [
                'user_id' => $user->id,
                'status' => 'approved',
                'is_active' => true,
                'verified_at' => now(),
            ]));
        }
    }
}
