<?php

namespace Database\Seeders;

use App\Models\Province;
use App\Models\City;
use Illuminate\Database\Seeder;

class ProvinceSeeder extends Seeder
{
    public function run(): void
    {
        $provinces = [
            'Aceh' => ['Banda Aceh', 'Langsa', 'Lhokseumawe', 'Sabang', 'Subulussalam'],
            'Sumatera Utara' => ['Medan', 'Binjai', 'Padang Sidempuan', 'Pematangsiantar', 'Sibolga', 'Tanjungbalai', 'Tebing Tinggi'],
            'Sumatera Barat' => ['Padang', 'Bukittinggi', 'Padang Panjang', 'Pariaman', 'Payakumbuh', 'Sawahlunto', 'Solok'],
            'Riau' => ['Pekanbaru', 'Dumai'],
            'Jambi' => ['Jambi', 'Sungai Penuh'],
            'Sumatera Selatan' => ['Palembang', 'Lubuklinggau', 'Pagar Alam', 'Prabumulih'],
            'Bengkulu' => ['Bengkulu'],
            'Lampung' => ['Bandar Lampung', 'Metro'],
            'Kepulauan Bangka Belitung' => ['Pangkalpinang'],
            'Kepulauan Riau' => ['Batam', 'Tanjungpinang'],
            'DKI Jakarta' => ['Jakarta Pusat', 'Jakarta Utara', 'Jakarta Barat', 'Jakarta Selatan', 'Jakarta Timur'],
            'Jawa Barat' => ['Bandung', 'Bekasi', 'Bogor', 'Cimahi', 'Cirebon', 'Depok', 'Sukabumi', 'Tasikmalaya'],
            'Jawa Tengah' => ['Semarang', 'Magelang', 'Pekalongan', 'Salatiga', 'Solo', 'Tegal'],
            'DI Yogyakarta' => ['Yogyakarta'],
            'Jawa Timur' => ['Surabaya', 'Batu', 'Blitar', 'Kediri', 'Madiun', 'Malang', 'Mojokerto', 'Pasuruan', 'Probolinggo'],
            'Banten' => ['Serang', 'Cilegon', 'Tangerang', 'Tangerang Selatan'],
            'Bali' => ['Denpasar'],
            'Nusa Tenggara Barat' => ['Mataram', 'Bima'],
            'Nusa Tenggara Timur' => ['Kupang'],
            'Kalimantan Barat' => ['Pontianak', 'Singkawang'],
            'Kalimantan Tengah' => ['Palangka Raya'],
            'Kalimantan Selatan' => ['Banjarmasin', 'Banjarbaru'],
            'Kalimantan Timur' => ['Samarinda', 'Balikpapan', 'Bontang'],
            'Kalimantan Utara' => ['Tarakan'],
            'Sulawesi Utara' => ['Manado', 'Bitung', 'Kotamobagu', 'Tomohon'],
            'Sulawesi Tengah' => ['Palu'],
            'Sulawesi Selatan' => ['Makassar', 'Palopo', 'Parepare'],
            'Sulawesi Tenggara' => ['Kendari', 'Baubau'],
            'Gorontalo' => ['Gorontalo'],
            'Sulawesi Barat' => ['Mamuju'],
            'Maluku' => ['Ambon', 'Tual'],
            'Maluku Utara' => ['Ternate', 'Tidore Kepulauan'],
            'Papua' => ['Jayapura'],
            'Papua Barat' => ['Manokwari', 'Sorong'],
        ];

        foreach ($provinces as $provinceName => $cities) {
            $province = Province::create(['name' => $provinceName]);
            
            foreach ($cities as $cityName) {
                City::create([
                    'province_id' => $province->id,
                    'name' => $cityName,
                ]);
            }
        }
    }
}
