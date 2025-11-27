# BeliDongBos - Panduan Penggunaan

## 1. Menjalankan Aplikasi

```bash
cd C:\Users\USER\BeliDongBos
php artisan serve
```

Akses di browser: **http://localhost:8000**

---

## 2. Akun Login

### Platform Admin
- **Email:** `admin@belidongbos.com`
- **Password:** `password123`
- **Akses:** Dashboard Platform, Verifikasi Penjual, Laporan PDF

### Akun Penjual (Sample)
| Email | Password | Nama Toko |
|-------|----------|-----------|
| calista@calistastore.com | password123 | Calista Gadget Store |
| aninditya@aninfashion.com | password123 | Aninditya Fashion House |
| angelica@angelicashop.com | password123 | Angelica Beauty Shop |
| miranda@mirandamart.com | password123 | Miranda Home & Living |
| keisha@keishasport.com | password123 | Keisha Sport & Hobby |

---

## 3. Konfigurasi Email (SMTP)

Edit file `.env` dan ganti konfigurasi email:

### Opsi A: Menggunakan Mailtrap (Untuk Development)
1. Daftar gratis di https://mailtrap.io
2. Buat inbox baru
3. Copy kredensial SMTP:

```env
MAIL_MAILER=smtp
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_mailtrap_username
MAIL_PASSWORD=your_mailtrap_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="noreply@belidongbos.com"
MAIL_FROM_NAME="BeliDongBos"
```

### Opsi B: Menggunakan Gmail (Untuk Production)
1. Aktifkan 2FA di akun Google
2. Buat App Password di: https://myaccount.google.com/apppasswords
3. Konfigurasi:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=emailkamu@gmail.com
MAIL_PASSWORD=app-password-16-karakter
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="emailkamu@gmail.com"
MAIL_FROM_NAME="BeliDongBos"
```

Setelah mengubah `.env`, jalankan:
```bash
php artisan config:clear
```

---

## 4. Melihat Database

Database menggunakan SQLite, tersimpan di:
```
C:\Users\USER\BeliDongBos\database\database.sqlite
```

### Opsi 1: Menggunakan DB Browser for SQLite
1. Download: https://sqlitebrowser.org/dl/
2. Buka file `database/database.sqlite`

### Opsi 2: Menggunakan Laravel Tinker
```bash
php artisan tinker
```

Contoh query:
```php
// Lihat semua user
App\Models\User::all();

// Lihat semua produk
App\Models\Product::with('seller')->get();

// Lihat penjual aktif
App\Models\Seller::where('is_active', true)->get();

// Hitung rating per produk
App\Models\Rating::count();
```

### Opsi 3: Menggunakan VS Code Extension
Install extension "SQLite Viewer" atau "SQLite" di VS Code.

---

## 5. Struktur Data Sample

Setelah seeding, database berisi:
- **34 Provinsi** dengan kota/kabupaten
- **15 Kategori** produk (masing-masing 5 produk)
- **1 Admin** platform
- **5 Penjual** aktif: Calista, Aninditya, Angelica, Miranda, Keisha
- **75 Produk** dengan foto (5 per kategori)
- **300+ Rating** dari pengunjung

---

## 6. Fitur Utama

### Pengunjung (Tanpa Login)
- Lihat katalog produk
- Cari produk (nama, toko, kategori, lokasi)
- Lihat detail produk + rating
- Beri komentar & rating (1-5)

### Penjual
- Daftar sebagai penjual
- Upload produk
- Dashboard dengan grafik stok & rating

### Platform Admin
- Verifikasi pendaftaran penjual
- Approve/Reject dengan email notifikasi
- Dashboard statistik
- Generate laporan PDF

---

## 7. Reset Database

Jika ingin reset data ke awal:
```bash
php artisan migrate:fresh --seed
```
