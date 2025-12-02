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
        // City IDs berdasarkan urutan insert di ProvinceSeeder:
        // Aceh (1-5), Sumut (6-12: Medan=6), Sumbar (13-19: Padang=13), Riau (20-21), Jambi (22-23)
        // Sumsel (24-27: Palembang=24), Bengkulu (28), Lampung (29-30), Babel (31), Kepri (32-33)
        // DKI Jakarta (34-38: JakPus=34, JakUt=35, JakBar=36, JakSel=37, JakTim=38)
        // Jabar (39-46: Bandung=39, Bekasi=40, Bogor=41), Jateng (47-52: Semarang=47, Solo=51)
        // DIY (53: Yogyakarta=53), Jatim (54-62: Surabaya=54, Malang=59)
        // Banten (63-66), Bali (67: Denpasar=67)
        
        $sellers = [
            // Tim Utama
            [
                'user' => ['name' => 'Calista Sahla', 'email' => 'calista@calistastore.com'],
                'seller' => [
                    'nama_toko' => 'Calista Store',
                    'nama_pic' => 'Calista Sahla',
                    'kontak_pic' => '081234567890',
                    'alamat_toko' => 'Jl. Thamrin No. 123, Jakarta Pusat',
                    'city_id' => 34, // Jakarta Pusat
                    'province_id' => 11, // DKI Jakarta
                    'nomor_hp' => '081234567890',
                    'email' => 'calista@calistastore.com',
                ],
            ],
            [
                'user' => ['name' => 'Angelica Putri', 'email' => 'angelica@angelicamart.com'],
                'seller' => [
                    'nama_toko' => 'Angelica Mart',
                    'nama_pic' => 'Angelica Putri',
                    'kontak_pic' => '082345678901',
                    'alamat_toko' => 'Jl. Braga No. 45, Bandung',
                    'city_id' => 39, // Bandung
                    'province_id' => 12, // Jawa Barat
                    'nomor_hp' => '082345678901',
                    'email' => 'angelica@angelicamart.com',
                ],
            ],
            [
                'user' => ['name' => 'Aninditya Nabilah', 'email' => 'aninditya@anindityamarket.com'],
                'seller' => [
                    'nama_toko' => 'Aninditya Market',
                    'nama_pic' => 'Aninditya Nabilah',
                    'kontak_pic' => '083456789012',
                    'alamat_toko' => 'Jl. Tunjungan No. 78, Surabaya',
                    'city_id' => 54, // Surabaya
                    'province_id' => 15, // Jawa Timur
                    'nomor_hp' => '083456789012',
                    'email' => 'aninditya@anindityamarket.com',
                ],
            ],
            [
                'user' => ['name' => 'Benjamin Hamonangan', 'email' => 'benjamin@benjaminshop.com'],
                'seller' => [
                    'nama_toko' => 'Benjamin Shop',
                    'nama_pic' => 'Benjamin Hamonangan',
                    'kontak_pic' => '084567890123',
                    'alamat_toko' => 'Jl. Malioboro No. 12, Yogyakarta',
                    'city_id' => 53, // Yogyakarta
                    'province_id' => 14, // DI Yogyakarta
                    'nomor_hp' => '084567890123',
                    'email' => 'benjamin@benjaminshop.com',
                ],
            ],
            // Public Figure
            [
                'user' => ['name' => 'Elon Musk', 'email' => 'elon@elonmarket.com'],
                'seller' => [
                    'nama_toko' => 'Elon Market',
                    'nama_pic' => 'Elon Musk',
                    'kontak_pic' => '085678901234',
                    'alamat_toko' => 'Jl. Gatot Subroto No. 56, Jakarta Selatan',
                    'city_id' => 37, // Jakarta Selatan
                    'province_id' => 11, // DKI Jakarta
                    'nomor_hp' => '085678901234',
                    'email' => 'elon@elonmarket.com',
                ],
            ],
            [
                'user' => ['name' => 'Taylor Swift', 'email' => 'taylor@taylorstore.com'],
                'seller' => [
                    'nama_toko' => 'Taylor Store',
                    'nama_pic' => 'Taylor Swift',
                    'kontak_pic' => '086789012345',
                    'alamat_toko' => 'Jl. Sunset Road No. 88, Denpasar',
                    'city_id' => 67, // Denpasar
                    'province_id' => 17, // Bali
                    'nomor_hp' => '086789012345',
                    'email' => 'taylor@taylorstore.com',
                ],
            ],
            [
                'user' => ['name' => 'Joko Widodo', 'email' => 'jokowi@jokowimart.com'],
                'seller' => [
                    'nama_toko' => 'Jokowi Mart',
                    'nama_pic' => 'Joko Widodo',
                    'kontak_pic' => '087890123456',
                    'alamat_toko' => 'Jl. Slamet Riyadi No. 100, Solo',
                    'city_id' => 51, // Solo
                    'province_id' => 13, // Jawa Tengah
                    'nomor_hp' => '087890123456',
                    'email' => 'jokowi@jokowimart.com',
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
