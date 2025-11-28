<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\Village;
use Illuminate\Database\Seeder;

class VillageSeeder extends Seeder
{
    public function run(): void
    {
        $villagesByCity = [
            'Jakarta Pusat' => ['Gambir', 'Tanah Abang', 'Menteng', 'Senen', 'Cempaka Putih', 'Johar Baru', 'Kemayoran', 'Sawah Besar'],
            'Jakarta Utara' => ['Penjaringan', 'Pademangan', 'Tanjung Priok', 'Koja', 'Kelapa Gading', 'Cilincing'],
            'Jakarta Barat' => ['Kembangan', 'Kebon Jeruk', 'Palmerah', 'Grogol Petamburan', 'Tambora', 'Taman Sari', 'Cengkareng', 'Kalideres'],
            'Jakarta Selatan' => ['Kebayoran Baru', 'Kebayoran Lama', 'Pesanggrahan', 'Cilandak', 'Pasar Minggu', 'Jagakarsa', 'Mampang Prapatan', 'Pancoran', 'Tebet', 'Setiabudi'],
            'Jakarta Timur' => ['Matraman', 'Pulo Gadung', 'Jatinegara', 'Duren Sawit', 'Kramat Jati', 'Makasar', 'Pasar Rebo', 'Ciracas', 'Cipayung', 'Cakung'],
            'Bandung' => ['Sukasari', 'Coblong', 'Babakan Ciparay', 'Bojongloa Kaler', 'Andir', 'Cicendo', 'Bandung Wetan', 'Sumur Bandung', 'Cibeunying Kidul', 'Batununggal'],
            'Bekasi' => ['Bekasi Timur', 'Bekasi Barat', 'Bekasi Utara', 'Bekasi Selatan', 'Rawalumbu', 'Medan Satria', 'Bantar Gebang', 'Pondok Gede', 'Jatiasih', 'Jatisampurna'],
            'Bogor' => ['Bogor Selatan', 'Bogor Timur', 'Bogor Utara', 'Bogor Tengah', 'Bogor Barat', 'Tanah Sareal'],
            'Depok' => ['Beji', 'Pancoran Mas', 'Cipayung', 'Sukmajaya', 'Cilodong', 'Cimanggis', 'Tapos', 'Sawangan', 'Limo', 'Cinere', 'Bojongsari'],
            'Tangerang' => ['Tangerang', 'Karawaci', 'Cibodas', 'Jatiuwung', 'Periuk', 'Neglasari', 'Batuceper', 'Benda', 'Cipondoh', 'Pinang', 'Ciledug', 'Larangan', 'Karang Tengah'],
            'Tangerang Selatan' => ['Serpong', 'Serpong Utara', 'Ciputat', 'Ciputat Timur', 'Pamulang', 'Pondok Aren', 'Setu'],
            'Semarang' => ['Semarang Tengah', 'Semarang Utara', 'Semarang Timur', 'Semarang Selatan', 'Semarang Barat', 'Gayamsari', 'Candisari', 'Gajahmungkur', 'Genuk', 'Pedurungan'],
            'Solo' => ['Laweyan', 'Serengan', 'Pasar Kliwon', 'Jebres', 'Banjarsari'],
            'Yogyakarta' => ['Tegalrejo', 'Jetis', 'Gondokusuman', 'Danurejan', 'Gedongtengen', 'Ngampilan', 'Wirobrajan', 'Mantrijeron', 'Kraton', 'Gondomanan', 'Pakualaman', 'Mergangsan', 'Umbulharjo', 'Kotagede'],
            'Surabaya' => ['Genteng', 'Bubutan', 'Tegalsari', 'Simokerto', 'Gubeng', 'Tambaksari', 'Mulyorejo', 'Sukolilo', 'Rungkut', 'Tenggilis Mejoyo', 'Gunung Anyar', 'Wonokromo', 'Wonocolo', 'Wiyung', 'Karang Pilang', 'Jambangan', 'Gayungan', 'Dukuh Pakis', 'Sawahan', 'Krembangan', 'Semampir', 'Pabean Cantikan', 'Kenjeran', 'Bulak', 'Asemrowo', 'Benowo', 'Lakarsantri', 'Sambikerep', 'Tandes', 'Sukomanunggal', 'Pakal'],
            'Malang' => ['Klojen', 'Blimbing', 'Kedungkandang', 'Sukun', 'Lowokwaru'],
            'Denpasar' => ['Denpasar Selatan', 'Denpasar Timur', 'Denpasar Barat', 'Denpasar Utara'],
            'Medan' => ['Medan Tuntungan', 'Medan Johor', 'Medan Amplas', 'Medan Denai', 'Medan Area', 'Medan Kota', 'Medan Maimun', 'Medan Polonia', 'Medan Baru', 'Medan Selayang', 'Medan Sunggal', 'Medan Helvetia', 'Medan Petisah', 'Medan Barat', 'Medan Timur', 'Medan Perjuangan', 'Medan Tembung', 'Medan Deli', 'Medan Labuhan', 'Medan Marelan', 'Medan Belawan'],
            'Makassar' => ['Mariso', 'Mamajang', 'Makassar', 'Ujung Pandang', 'Wajo', 'Bontoala', 'Tallo', 'Ujung Tanah', 'Panakkukang', 'Rappocini', 'Manggala', 'Biringkanaya', 'Tamalanrea', 'Tamalate'],
            'Palembang' => ['Ilir Barat I', 'Ilir Barat II', 'Ilir Timur I', 'Ilir Timur II', 'Ilir Timur III', 'Seberang Ulu I', 'Seberang Ulu II', 'Sukarami', 'Sako', 'Kemuning', 'Kalidoni', 'Bukit Kecil', 'Gandus', 'Kertapati', 'Plaju', 'Alang-Alang Lebar'],
            'Pekanbaru' => ['Tampan', 'Payung Sekaki', 'Bukit Raya', 'Marpoyan Damai', 'Tenayan Raya', 'Lima Puluh', 'Sail', 'Pekanbaru Kota', 'Sukajadi', 'Senapelan', 'Rumbai', 'Rumbai Pesisir'],
            'Padang' => ['Padang Selatan', 'Padang Timur', 'Padang Barat', 'Padang Utara', 'Nanggalo', 'Kuranji', 'Pauh', 'Koto Tangah', 'Lubuk Kilangan', 'Lubuk Begalung', 'Bungus Teluk Kabung'],
            'Banjarmasin' => ['Banjarmasin Selatan', 'Banjarmasin Timur', 'Banjarmasin Barat', 'Banjarmasin Tengah', 'Banjarmasin Utara'],
            'Samarinda' => ['Samarinda Kota', 'Samarinda Seberang', 'Samarinda Ulu', 'Samarinda Ilir', 'Sungai Kunjang', 'Sambutan', 'Samarinda Utara', 'Sungai Pinang', 'Palaran', 'Loa Janan Ilir'],
            'Balikpapan' => ['Balikpapan Selatan', 'Balikpapan Kota', 'Balikpapan Utara', 'Balikpapan Tengah', 'Balikpapan Timur', 'Balikpapan Barat'],
            'Manado' => ['Malalayang', 'Sario', 'Wanea', 'Wenang', 'Tikala', 'Paal Dua', 'Mapanget', 'Singkil', 'Tuminting', 'Bunaken', 'Bunaken Kepulauan'],
            'Pontianak' => ['Pontianak Selatan', 'Pontianak Tenggara', 'Pontianak Timur', 'Pontianak Barat', 'Pontianak Kota', 'Pontianak Utara'],
        ];

        foreach ($villagesByCity as $cityName => $villages) {
            $city = City::where('name', $cityName)->first();
            if ($city) {
                foreach ($villages as $villageName) {
                    Village::create([
                        'city_id' => $city->id,
                        'name' => $villageName,
                    ]);
                }
            }
        }

        $citiesWithoutVillages = City::whereDoesntHave('villages')->get();
        foreach ($citiesWithoutVillages as $city) {
            $defaultVillages = [
                $city->name . ' Pusat',
                $city->name . ' Utara',
                $city->name . ' Selatan',
                $city->name . ' Timur',
                $city->name . ' Barat',
            ];
            foreach ($defaultVillages as $villageName) {
                Village::create([
                    'city_id' => $city->id,
                    'name' => $villageName,
                ]);
            }
        }
    }
}
