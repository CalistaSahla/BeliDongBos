<?php

namespace Database\Seeders;

use App\Models\Rating;
use App\Models\Product;
use App\Models\Province;
use Illuminate\Database\Seeder;

class RatingSeeder extends Seeder
{
    public function run(): void
    {
        $products = Product::all();
        $provinces = Province::all();
        
        $names = [
            // Public Figures & Celebrities
            'Selena Gomez', 'Justin Bieber', 'Donald Trump', 'Elon Musk', 'Taylor Swift',
            'Ariana Grande', 'Kim Kardashian', 'Cristiano Ronaldo', 'Lionel Messi', 'BTS Jungkook',
            'Blackpink Lisa', 'Kylie Jenner', 'Dwayne Johnson', 'Barack Obama', 'Bill Gates',
            'Mark Zuckerberg', 'Jeff Bezos', 'Oprah Winfrey', 'Ed Sheeran', 'Bruno Mars',
            'Rihanna', 'Beyonce', 'Lady Gaga', 'Drake', 'Post Malone',
            'Joko Widodo', 'Raffi Ahmad', 'Nagita Slavina', 'Atta Halilintar', 'Deddy Corbuzier'
        ];

        $comments = [
            5 => [
                'Produk sangat bagus, sesuai deskripsi. Pengiriman cepat. Recommended!',
                'Mantap! Kualitas oke banget, packing rapi. Penjual ramah.',
                'Barang original 100%. Sangat puas dengan pembelian ini.',
                'Keren banget produknya, sesuai ekspektasi. Akan order lagi.',
                'Pengalaman belanja yang menyenangkan. Barang sampai dengan selamat.',
            ],
            4 => [
                'Produk bagus, cuma pengiriman agak lama. Overall puas.',
                'Kualitas lumayan bagus untuk harga segini. Worth it!',
                'Barangnya oke, sesuai gambar. Cuma packingnya bisa lebih baik.',
                'Good product, seller fast response. Minor issue tapi solved.',
                'Recommended seller, barang sesuai. Semoga awet ya.',
            ],
            3 => [
                'Produk standar, tidak istimewa tapi tidak mengecewakan juga.',
                'Lumayan lah untuk harga segitu. Bisa jadi alternatif.',
                'Pengiriman agak lama, tapi barang sampai dengan baik.',
                'Kualitas biasa saja, sesuai harga. Ekspektasi jangan terlalu tinggi.',
            ],
            2 => [
                'Barang kurang sesuai ekspektasi. Warna berbeda dari foto.',
                'Pengiriman sangat lama, hampir 2 minggu baru sampai.',
            ],
            1 => [
                'Kecewa, barang tidak sesuai deskripsi sama sekali.',
            ],
        ];

        foreach ($products as $product) {
            $numRatings = rand(2, 8);
            
            for ($i = 0; $i < $numRatings; $i++) {
                $rating = $this->weightedRandom([5 => 40, 4 => 30, 3 => 15, 2 => 10, 1 => 5]);
                $province = $provinces->random();
                $name = $names[array_rand($names)];
                $comment = $comments[$rating][array_rand($comments[$rating])];
                
                Rating::create([
                    'product_id' => $product->id,
                    'nama' => $name,
                    'nomor_hp' => '08' . rand(1000000000, 9999999999),
                    'email' => strtolower(str_replace(' ', '.', $name)) . rand(1, 99) . '@gmail.com',
                    'rating' => $rating,
                    'komentar' => $comment,
                    'province_id' => $province->id,
                    'created_at' => now()->subDays(rand(1, 60)),
                ]);
            }
            
            $product->updateRatingStats();
        }
    }

    private function weightedRandom(array $weights): int
    {
        $sum = array_sum($weights);
        $rand = rand(1, $sum);
        
        foreach ($weights as $value => $weight) {
            $rand -= $weight;
            if ($rand <= 0) {
                return $value;
            }
        }
        
        return array_key_first($weights);
    }
}
