<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Seller;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $sellers = Seller::where('status', 'approved')->get();
        
        if ($sellers->isEmpty()) {
            return;
        }

        // 15 kategori x 5 produk = 75 produk minimum
        $products = [
            // Kategori 1: Elektronik
            ['nama' => 'Samsung Galaxy A54 5G 128GB', 'kategori' => 1, 'harga' => 5999000, 'stok' => 25, 'deskripsi' => 'Smartphone Samsung Galaxy A54 5G dengan layar Super AMOLED 6.4 inch, kamera 50MP, RAM 8GB. Garansi resmi 1 tahun.', 'berat' => '200 gram', 'foto_utama' => '/images/A54.webp'],
            ['nama' => 'iPhone 14 Pro Max 256GB', 'kategori' => 1, 'harga' => 21999000, 'stok' => 10, 'deskripsi' => 'iPhone 14 Pro Max dengan chip A16 Bionic, Dynamic Island, kamera 48MP. Garansi resmi iBox.', 'berat' => '240 gram', 'foto_utama' => '/images/ip14PM.jpg'],
            ['nama' => 'Xiaomi Redmi Note 12 Pro', 'kategori' => 1, 'harga' => 3499000, 'stok' => 50, 'deskripsi' => 'Redmi Note 12 Pro dengan kamera 108MP, layar AMOLED 120Hz, fast charging 67W.', 'berat' => '190 gram', 'foto_utama' => '/images/redmi12pro.webp'],
            ['nama' => 'Smart TV LED 43 inch Android', 'kategori' => 1, 'harga' => 4299000, 'stok' => 15, 'deskripsi' => 'Smart TV LED 43 inch dengan Android TV, resolusi Full HD, Netflix, YouTube built-in.', 'berat' => '8 kg', 'foto_utama' => '/images/tvled.webp'],
            ['nama' => 'TWS Earbuds Pro Wireless', 'kategori' => 1, 'harga' => 899000, 'stok' => 100, 'deskripsi' => 'True Wireless Stereo Earbuds dengan Active Noise Cancellation, battery 30 jam.', 'berat' => '50 gram', 'foto_utama' => '/images/tws.webp'],
            
            // Kategori 2: Fashion Pria
            ['nama' => 'Kemeja Batik Pria Premium', 'kategori' => 2, 'harga' => 299000, 'stok' => 45, 'deskripsi' => 'Kemeja batik pria lengan panjang motif parang, bahan katun premium. Size M-XXL.', 'berat' => '250 gram', 'foto_utama' => '/images/batik.webp'],
            ['nama' => 'Jaket Kulit Pria Casual', 'kategori' => 2, 'harga' => 750000, 'stok' => 20, 'deskripsi' => 'Jaket kulit sintetis premium untuk pria, model slim fit, warna hitam dan coklat.', 'berat' => '800 gram', 'foto_utama' => '/images/jaket.jpg'],
            ['nama' => 'Celana Chino Pria Slim Fit', 'kategori' => 2, 'harga' => 189000, 'stok' => 60, 'deskripsi' => 'Celana chino pria model slim fit, bahan cotton stretch. Warna khaki, navy, hitam.', 'berat' => '350 gram', 'foto_utama' => '/images/celana.webp'],
            ['nama' => 'Sepatu Sneakers Pria Sport', 'kategori' => 2, 'harga' => 459000, 'stok' => 35, 'deskripsi' => 'Sepatu sneakers pria untuk olahraga dan casual, sol empuk, ringan. Size 39-44.', 'berat' => '600 gram', 'foto_utama' => '/images/sepatu.webp'],
            ['nama' => 'Kaos Polos Pria Cotton Combed', 'kategori' => 2, 'harga' => 89000, 'stok' => 150, 'deskripsi' => 'Kaos polos pria bahan cotton combed 30s, nyaman dan adem. Tersedia banyak warna.', 'berat' => '180 gram', 'foto_utama' => '/images/kaos.webp'],
            
            // Kategori 3: Fashion Wanita
            ['nama' => 'Dress Wanita Elegant Satin', 'kategori' => 3, 'harga' => 350000, 'stok' => 30, 'deskripsi' => 'Dress wanita elegant untuk pesta, bahan satin premium, cutting A-line. Size S-L.', 'berat' => '300 gram', 'foto_utama' => '/images/dress.webp'],
            ['nama' => 'Gamis Syari Premium Wolfis', 'kategori' => 3, 'harga' => 275000, 'stok' => 55, 'deskripsi' => 'Gamis syari wanita bahan wolfis premium, tidak menerawang. Free hijab square.', 'berat' => '450 gram', 'foto_utama' => '/images/gamis.webp'],
            ['nama' => 'Tas Wanita Tote Bag Import', 'kategori' => 3, 'harga' => 425000, 'stok' => 25, 'deskripsi' => 'Tas wanita model tote bag, bahan kulit sintetis berkualitas. Warna cream, hitam, pink.', 'berat' => '500 gram', 'foto_utama' => '/images/taswanita.webp'],
            ['nama' => 'High Heels Wanita 7cm Suede', 'kategori' => 3, 'harga' => 289000, 'stok' => 40, 'deskripsi' => 'High heels wanita tinggi 7cm, model pointed toe, bahan suede. Size 36-40.', 'berat' => '400 gram', 'foto_utama' => '/images/heels.webp'],
            ['nama' => 'Blouse Wanita Lengan Panjang', 'kategori' => 3, 'harga' => 159000, 'stok' => 70, 'deskripsi' => 'Blouse wanita casual lengan panjang, bahan katun rayon, adem dan nyaman.', 'berat' => '200 gram', 'foto_utama' => '/images/blouse.jpg'],
            
            // Kategori 4: Makanan & Minuman
            ['nama' => 'Kopi Arabica Gayo Premium 250gr', 'kategori' => 4, 'harga' => 89000, 'stok' => 200, 'deskripsi' => 'Kopi arabica Gayo Aceh premium, roasting medium, aroma harum. Kemasan 250 gram.', 'berat' => '260 gram', 'foto_utama' => '/images/kopi.webp'],
            ['nama' => 'Madu Hutan Asli Kalimantan 500ml', 'kategori' => 4, 'harga' => 150000, 'stok' => 75, 'deskripsi' => 'Madu hutan asli Kalimantan, 100% murni tanpa campuran. Botol kaca 500ml.', 'berat' => '700 gram', 'foto_utama' => '/images/madu.webp'],
            ['nama' => 'Sambal Teri Medan Super Pedas', 'kategori' => 4, 'harga' => 45000, 'stok' => 150, 'deskripsi' => 'Sambal teri Medan homemade, pedas gurih. Kemasan jar 200gr.', 'berat' => '250 gram', 'foto_utama' => '/images/sambal.webp'],
            ['nama' => 'Keripik Singkong Balado 500gr', 'kategori' => 4, 'harga' => 35000, 'stok' => 300, 'deskripsi' => 'Keripik singkong rasa balado pedas manis, renyah dan gurih. Kemasan 500gr.', 'berat' => '520 gram', 'foto_utama' => '/images/keripik.webp'],
            ['nama' => 'Teh Hijau Organik Premium', 'kategori' => 4, 'harga' => 65000, 'stok' => 120, 'deskripsi' => 'Teh hijau organik dari perkebunan Puncak, kaya antioksidan. Kemasan 100gr.', 'berat' => '120 gram', 'foto_utama' => '/images/teh.webp'],
            
            // Kategori 5: Kesehatan
            ['nama' => 'Masker Medis 3 Ply Box 50pcs', 'kategori' => 5, 'harga' => 45000, 'stok' => 500, 'deskripsi' => 'Masker medis 3 ply disposable, isi 50 pcs per box. Sertifikat SNI.', 'berat' => '200 gram', 'foto_utama' => '/images/masker.webp'],
            ['nama' => 'Hand Sanitizer Gel 500ml', 'kategori' => 5, 'harga' => 35000, 'stok' => 300, 'deskripsi' => 'Hand sanitizer gel dengan kandungan alkohol 70%, membunuh 99.9% kuman.', 'berat' => '550 gram', 'foto_utama' => '/images/handsanitizer.jpg'],
            ['nama' => 'Vitamin C 1000mg Isi 30 Tablet', 'kategori' => 5, 'harga' => 85000, 'stok' => 200, 'deskripsi' => 'Suplemen vitamin C 1000mg untuk daya tahan tubuh. Isi 30 tablet.', 'berat' => '100 gram', 'foto_utama' => '/images/vidC.jpg'],
            ['nama' => 'Thermometer Digital Infrared', 'kategori' => 5, 'harga' => 250000, 'stok' => 50, 'deskripsi' => 'Thermometer digital infrared non-contact, akurat dan cepat. Garansi 1 tahun.', 'berat' => '150 gram', 'foto_utama' => '/images/thermometer.jpg'],
            ['nama' => 'Tensimeter Digital Lengan Atas', 'kategori' => 5, 'harga' => 350000, 'stok' => 30, 'deskripsi' => 'Alat ukur tekanan darah digital untuk lengan atas, layar LCD besar.', 'berat' => '400 gram', 'foto_utama' => '/images/tensimeter.jpg'],
            
            // Kategori 6: Kecantikan
            ['nama' => 'Skincare Set Whitening Complete', 'kategori' => 6, 'harga' => 299000, 'stok' => 80, 'deskripsi' => 'Paket skincare lengkap: facial wash, toner, serum, moisturizer, sunscreen. BPOM.', 'berat' => '500 gram', 'foto_utama' => '/images/skincare.webp'],
            ['nama' => 'Lipstik Matte Waterproof', 'kategori' => 6, 'harga' => 75000, 'stok' => 120, 'deskripsi' => 'Lipstik matte tahan lama, waterproof, 12 shade warna. Halal MUI.', 'berat' => '30 gram', 'foto_utama' => '/images/lipstik.webp'],
            ['nama' => 'Serum Vitamin C 20% 30ml', 'kategori' => 6, 'harga' => 159000, 'stok' => 90, 'deskripsi' => 'Serum vitamin C 20% untuk mencerahkan dan anti-aging. Kemasan 30ml.', 'berat' => '80 gram', 'foto_utama' => '/images/serum.webp'],
            ['nama' => 'Cushion Foundation SPF50', 'kategori' => 6, 'harga' => 189000, 'stok' => 65, 'deskripsi' => 'Cushion foundation dengan SPF50, coverage medium, hasil natural dewy.', 'berat' => '100 gram', 'foto_utama' => '/images/cushion.jpg'],
            ['nama' => 'Parfum Wanita EDT 100ml', 'kategori' => 6, 'harga' => 450000, 'stok' => 40, 'deskripsi' => 'Parfum wanita eau de toilette, wangi floral fruity, tahan lama seharian.', 'berat' => '250 gram', 'foto_utama' => '/images/parfum.webp'],
            
            // Kategori 7: Rumah Tangga
            ['nama' => 'Blender Multi Fungsi 2L', 'kategori' => 7, 'harga' => 425000, 'stok' => 22, 'deskripsi' => 'Blender multi fungsi kapasitas 2 liter, 3 speed + pulse. Garansi 1 tahun.', 'berat' => '2.0 kg', 'foto_utama' => '/images/blender.jpg'],
            ['nama' => 'Rice Cooker Digital 1.8L', 'kategori' => 7, 'harga' => 650000, 'stok' => 28, 'deskripsi' => 'Rice cooker digital kapasitas 1.8 liter, multi cooking. Low watt hemat listrik.', 'berat' => '3 kg', 'foto_utama' => '/images/ricecook.jpg'],
            ['nama' => 'Set Panci Stainless Steel 5pcs', 'kategori' => 7, 'harga' => 550000, 'stok' => 15, 'deskripsi' => 'Set panci stainless steel 5 pcs berbagai ukuran, cocok semua kompor.', 'berat' => '4 kg', 'foto_utama' => '/images/panci.webp'],
            ['nama' => 'Vacuum Cleaner Portable 120W', 'kategori' => 7, 'harga' => 350000, 'stok' => 35, 'deskripsi' => 'Vacuum cleaner portable wireless, daya hisap kuat, cocok untuk mobil dan rumah.', 'berat' => '1.2 kg', 'foto_utama' => '/images/vacuum.webp'],
            ['nama' => 'Dispenser Air Galon Bawah', 'kategori' => 7, 'harga' => 1250000, 'stok' => 10, 'deskripsi' => 'Dispenser galon bawah dengan pemanas dan pendingin, desain modern.', 'berat' => '12 kg', 'foto_utama' => '/images/dispenser.webp'],
            
            // Kategori 8: Olahraga
            ['nama' => 'Dumbbell Set Adjustable 20kg', 'kategori' => 8, 'harga' => 850000, 'stok' => 18, 'deskripsi' => 'Set dumbbell adjustable 20kg (2x10kg), bahan besi cor dengan lapisan karet.', 'berat' => '22 kg', 'foto_utama' => '/images/dumbell.jpg'],
            ['nama' => 'Yoga Mat Premium 6mm', 'kategori' => 8, 'harga' => 189000, 'stok' => 65, 'deskripsi' => 'Matras yoga premium tebal 6mm, anti slip, bahan NBR. Ukuran 183x61cm. Free tas.', 'berat' => '1.2 kg', 'foto_utama' => '/images/yoga.jpg'],
            ['nama' => 'Raket Badminton Carbon Pro', 'kategori' => 8, 'harga' => 450000, 'stok' => 30, 'deskripsi' => 'Raket badminton full carbon, berat 85gr, tension max 32lbs.', 'berat' => '150 gram', 'foto_utama' => '/images/raket.jpg'],
            ['nama' => 'Sepatu Futsal Indoor', 'kategori' => 8, 'harga' => 375000, 'stok' => 40, 'deskripsi' => 'Sepatu futsal untuk lapangan indoor, sol karet non-marking. Size 39-44.', 'berat' => '500 gram', 'foto_utama' => '/images/sptfutsal.jpg'],
            ['nama' => 'Treadmill Elektrik Lipat', 'kategori' => 8, 'harga' => 3500000, 'stok' => 5, 'deskripsi' => 'Treadmill elektrik bisa dilipat, max speed 12km/h, layar LCD, speaker bluetooth.', 'berat' => '35 kg', 'foto_utama' => '/images/treadmill.webp'],
            
            // Kategori 9: Otomotif
            ['nama' => 'Oli Mesin Mobil 4L SAE 10W-40', 'kategori' => 9, 'harga' => 350000, 'stok' => 100, 'deskripsi' => 'Oli mesin mobil fully synthetic SAE 10W-40, kemasan 4 liter.', 'berat' => '4.2 kg', 'foto_utama' => '/images/oli.jpg'],
            ['nama' => 'Kamera Dashcam Dual Lens', 'kategori' => 9, 'harga' => 450000, 'stok' => 45, 'deskripsi' => 'Kamera dashcam dual lens depan belakang, resolusi Full HD 1080p.', 'berat' => '200 gram', 'foto_utama' => '/images/dashcam.webp'],
            ['nama' => 'Cover Jok Mobil Universal', 'kategori' => 9, 'harga' => 285000, 'stok' => 60, 'deskripsi' => 'Cover jok mobil universal, bahan kulit sintetis premium, mudah dipasang.', 'berat' => '2 kg', 'foto_utama' => '/images/jok.jpg'],
            ['nama' => 'Helm Half Face SNI', 'kategori' => 9, 'harga' => 175000, 'stok' => 80, 'deskripsi' => 'Helm half face standar SNI, visor anti gores, ventilasi udara baik.', 'berat' => '1 kg', 'foto_utama' => '/images/helm.jpg'],
            ['nama' => 'Pompa Ban Portable Digital', 'kategori' => 9, 'harga' => 250000, 'stok' => 55, 'deskripsi' => 'Pompa ban elektrik portable dengan display digital, bisa untuk mobil dan motor.', 'berat' => '800 gram', 'foto_utama' => '/images/pompa.webp'],
            
            // Kategori 10: Hobi & Koleksi
            ['nama' => 'Action Figure Anime 20cm', 'kategori' => 10, 'harga' => 350000, 'stok' => 25, 'deskripsi' => 'Action figure karakter anime populer, tinggi 20cm, detail halus, bisa dipose.', 'berat' => '400 gram', 'foto_utama' => '/images/anime.jpg'],
            ['nama' => 'Puzzle 1000 Pieces Landscape', 'kategori' => 10, 'harga' => 150000, 'stok' => 40, 'deskripsi' => 'Puzzle 1000 pieces gambar pemandangan alam, ukuran jadi 70x50cm.', 'berat' => '600 gram', 'foto_utama' => '/images/puzzle.jpg'],
            ['nama' => 'Model Kit Gundam HG 1/144', 'kategori' => 10, 'harga' => 250000, 'stok' => 30, 'deskripsi' => 'Model kit Gundam skala 1/144 HG, snap fit tanpa lem, manual lengkap.', 'berat' => '300 gram', 'foto_utama' => '/images/gundam.jpg'],
            ['nama' => 'Kamera Polaroid Instant', 'kategori' => 10, 'harga' => 850000, 'stok' => 15, 'deskripsi' => 'Kamera instant polaroid, hasil cetak langsung jadi, desain retro aesthetic.', 'berat' => '450 gram', 'foto_utama' => '/images/kamera.jpg'],
            ['nama' => 'Drone Mini dengan Kamera HD', 'kategori' => 10, 'harga' => 750000, 'stok' => 20, 'deskripsi' => 'Drone mini dengan kamera HD 720p, flight time 15 menit, mudah dikendalikan.', 'berat' => '350 gram', 'foto_utama' => '/images/drone.webp'],
            
            // Kategori 11: Buku & Alat Tulis
            ['nama' => 'Novel Best Seller 2024', 'kategori' => 11, 'harga' => 89000, 'stok' => 100, 'deskripsi' => 'Novel best seller karya penulis ternama, cerita inspiratif. Soft cover 350 halaman.', 'berat' => '300 gram', 'foto_utama' => '/images/novel.jpg'],
            ['nama' => 'Buku Tulis A5 Hardcover Set 5', 'kategori' => 11, 'harga' => 75000, 'stok' => 150, 'deskripsi' => 'Set 5 buku tulis A5 hardcover, 100 lembar per buku, kertas HVS 80gsm.', 'berat' => '800 gram', 'foto_utama' => '/images/bukutulis.jpg'],
            ['nama' => 'Pensil Warna 48 Warna Set', 'kategori' => 11, 'harga' => 125000, 'stok' => 80, 'deskripsi' => 'Set pensil warna 48 warna, pigmen pekat, mudah diblend. Cocok untuk sketsa.', 'berat' => '500 gram', 'foto_utama' => '/images/pensilwarna.webp'],
            ['nama' => 'Pulpen Gel 0.5mm Box 12pcs', 'kategori' => 11, 'harga' => 48000, 'stok' => 200, 'deskripsi' => 'Pulpen gel hitam 0.5mm, tinta lancar tidak mudah blobor. Isi 12 pcs.', 'berat' => '150 gram', 'foto_utama' => '/images/pen.jpg'],
            ['nama' => 'Kamus Bahasa Inggris Lengkap', 'kategori' => 11, 'harga' => 150000, 'stok' => 50, 'deskripsi' => 'Kamus bahasa Inggris-Indonesia lengkap, hardcover, 1200 halaman.', 'berat' => '1.2 kg', 'foto_utama' => '/images/kamus.jpg'],
            
            // Kategori 12: Ibu & Bayi
            ['nama' => 'Popok Bayi Premium M Isi 50', 'kategori' => 12, 'harga' => 175000, 'stok' => 200, 'deskripsi' => 'Popok bayi premium size M (6-11kg), daya serap tinggi, lembut di kulit.', 'berat' => '1.5 kg', 'foto_utama' => '/images/popok.jpg'],
            ['nama' => 'Botol Susu Anti Kolik 260ml', 'kategori' => 12, 'harga' => 125000, 'stok' => 100, 'deskripsi' => 'Botol susu bayi anti kolik, bahan BPA free, nipple slow flow.', 'berat' => '150 gram', 'foto_utama' => '/images/botol.jpg'],
            ['nama' => 'Stroller Bayi Lipat Compact', 'kategori' => 12, 'harga' => 1250000, 'stok' => 15, 'deskripsi' => 'Stroller bayi bisa dilipat compact, ringan, roda 360 derajat, ada kanopi.', 'berat' => '6 kg', 'foto_utama' => '/images/stroller.jpg'],
            ['nama' => 'Gendongan Bayi Ergonomis', 'kategori' => 12, 'harga' => 350000, 'stok' => 40, 'deskripsi' => 'Gendongan bayi ergonomis, 4 posisi gendong, support tulang belakang bayi.', 'berat' => '500 gram', 'foto_utama' => '/images/gendongan.jpg'],
            ['nama' => 'Baby Wipes Fragrance Free 80s', 'kategori' => 12, 'harga' => 35000, 'stok' => 300, 'deskripsi' => 'Tisu basah bayi tanpa pewangi, lembut dan aman untuk kulit sensitif. Isi 80 lembar.', 'berat' => '400 gram', 'foto_utama' => '/images/babywipes.jpg'],
            
            // Kategori 13: Komputer & Laptop
            ['nama' => 'Laptop ASUS VivoBook 14 i5', 'kategori' => 13, 'harga' => 8999000, 'stok' => 12, 'deskripsi' => 'Laptop ASUS VivoBook Intel Core i5 Gen 12, RAM 8GB, SSD 512GB, layar 14 FHD.', 'berat' => '1.6 kg', 'foto_utama' => '/images/laptop.jpg'],
            ['nama' => 'Mouse Gaming RGB Wireless', 'kategori' => 13, 'harga' => 350000, 'stok' => 60, 'deskripsi' => 'Mouse gaming wireless dengan RGB lighting, DPI adjustable 16000.', 'berat' => '100 gram', 'foto_utama' => '/images/mouse.jpg'],
            ['nama' => 'Keyboard Mechanical TKL', 'kategori' => 13, 'harga' => 450000, 'stok' => 45, 'deskripsi' => 'Keyboard mechanical tenkeyless, switch blue clicky, RGB backlit.', 'berat' => '700 gram', 'foto_utama' => '/images/keyboard.jpg'],
            ['nama' => 'Monitor LED 24 inch FHD 75Hz', 'kategori' => 13, 'harga' => 1750000, 'stok' => 20, 'deskripsi' => 'Monitor LED 24 inch Full HD 1080p, refresh rate 75Hz, port HDMI VGA.', 'berat' => '4 kg', 'foto_utama' => '/images/monitor.jpg'],
            ['nama' => 'Webcam HD 1080p Autofocus', 'kategori' => 13, 'harga' => 450000, 'stok' => 50, 'deskripsi' => 'Webcam Full HD 1080p dengan autofocus, built-in mic, plug and play.', 'berat' => '150 gram', 'foto_utama' => '/images/webcamm.webp'],
            
            // Kategori 14: Handphone & Tablet
            ['nama' => 'iPad Air 5 WiFi 64GB', 'kategori' => 14, 'harga' => 10999000, 'stok' => 8, 'deskripsi' => 'iPad Air generasi 5 dengan chip M1, layar Liquid Retina 10.9 inch. Garansi Apple.', 'berat' => '460 gram', 'foto_utama' => '/images/ipad.png'],
            ['nama' => 'Samsung Galaxy Tab S8 11 inch', 'kategori' => 14, 'harga' => 9499000, 'stok' => 12, 'deskripsi' => 'Samsung Galaxy Tab S8 dengan layar 11 inch, S Pen included, RAM 8GB.', 'berat' => '500 gram', 'foto_utama' => '/images/tabS8.webp'],
            ['nama' => 'Powerbank 20000mAh Fast Charge', 'kategori' => 14, 'harga' => 299000, 'stok' => 100, 'deskripsi' => 'Powerbank 20000mAh dengan fast charging 22.5W, dual port USB-A dan USB-C.', 'berat' => '400 gram', 'foto_utama' => '/images/powerbank.webp'],
            ['nama' => 'Case HP Premium Leather', 'kategori' => 14, 'harga' => 89000, 'stok' => 200, 'deskripsi' => 'Case HP bahan kulit premium, slot kartu, magnetic closure. Tersedia banyak model.', 'berat' => '50 gram', 'foto_utama' => '/images/caseHP.png'],
            ['nama' => 'Charger Fast Charging 33W', 'kategori' => 14, 'harga' => 150000, 'stok' => 150, 'deskripsi' => 'Charger fast charging 33W, support QC3.0 dan PD, include kabel Type-C.', 'berat' => '100 gram', 'foto_utama' => '/images/cassan.webp'],
            
            // Kategori 15: Perawatan Hewan
            ['nama' => 'Makanan Kucing Premium 1kg', 'kategori' => 15, 'harga' => 85000, 'stok' => 150, 'deskripsi' => 'Makanan kucing dewasa premium, nutrisi lengkap, rasa salmon. Kemasan 1kg.', 'berat' => '1.1 kg', 'foto_utama' => '/images/wiskas.jpg'],
            ['nama' => 'Pasir Kucing Wangi 10L', 'kategori' => 15, 'harga' => 65000, 'stok' => 100, 'deskripsi' => 'Pasir kucing clumping wangi lavender, cepat menggumpal, anti bau.', 'berat' => '8 kg', 'foto_utama' => '/images/pasirkucing.jpg'],
            ['nama' => 'Kandang Hamster Lengkap', 'kategori' => 15, 'harga' => 250000, 'stok' => 30, 'deskripsi' => 'Kandang hamster lengkap dengan roda, tempat makan minum, dan rumah-rumahan.', 'berat' => '2 kg', 'foto_utama' => '/images/kandanghamster.webp'],
            ['nama' => 'Kalung Anjing Kulit Adjustable', 'kategori' => 15, 'harga' => 75000, 'stok' => 80, 'deskripsi' => 'Kalung anjing bahan kulit asli, adjustable size S-L, ada ring untuk leash.', 'berat' => '100 gram', 'foto_utama' => '/images/kalunganjing.jpg'],
            ['nama' => 'Akuarium Mini Set Filter LED', 'kategori' => 15, 'harga' => 350000, 'stok' => 25, 'deskripsi' => 'Akuarium mini 30x20x25cm lengkap dengan filter dan lampu LED, cocok untuk ikan hias.', 'berat' => '5 kg', 'foto_utama' => '/images/aquarium.jpg'],
        ];

        $sellerIndex = 0;
        foreach ($products as $index => $productData) {
            $seller = $sellers[$sellerIndex % count($sellers)];
            $photoId = ($index * 17) + 100;
            
            Product::create([
                'seller_id' => $seller->id,
                'category_id' => $productData['kategori'],
                'nama_produk' => $productData['nama'],
                'slug' => Str::slug($productData['nama']) . '-' . Str::random(5),
                'deskripsi' => $productData['deskripsi'],
                'harga' => $productData['harga'],
                'stok' => $productData['stok'],
                'berat' => $productData['berat'],
                'kondisi' => 'baru',
                'min_pembelian' => '1',
                'foto_utama' => $productData['foto_utama'],
                'is_active' => true,
            ]);
            
            $sellerIndex++;
        }
    }
}
