# Sistem Informasi Akademik SIAKAD
By Ahmad Riko Dyansyah

Aplikasi berbasis Laravel dengan tiga bagian utama:

1. **Halaman Login** — satu pintu masuk untuk admin & mahasiswa, otomatis diarahkan sesuai peran (role).
2. **Beranda Mahasiswa** — tampilan bergaya aplikasi mobile (bottom navigation, kartu ringkasan IPK/SKS, jadwal, pengumuman).
3. **Dashboard Admin** — manajemen data mahasiswa (CRUD) lengkap dengan statistik, pencarian, dan filter status.

## Struktur Peran (Role)

| Role        | Redirect setelah login       | Middleware   |
|-------------|-------------------------------|--------------|
| `admin`     | `/admin/dashboard`            | `admin`      |
| `mahasiswa` | `/mahasiswa/beranda`          | `mahasiswa`  |

## Cara Instalasi

> **Prasyarat:** PHP >= 8.1, Composer, MySQL/MariaDB.

```bash
# 1. Masuk ke folder project
cd mahasiswa-app

# 2. Install dependency PHP (mengunduh framework Laravel dari Packagist)
composer install

# 3. Salin file environment lalu generate APP_KEY
cp .env.example .env
php artisan key:generate

# 4. Atur koneksi database di file .env
#    DB_DATABASE=mahasiswa_app
#    DB_USERNAME=root
#    DB_PASSWORD=

# 5. Buat database "mahasiswa_app" di MySQL, lalu jalankan migrasi + seeder
php artisan migrate --seed

# 6. Buat symlink storage (wajib untuk foto profil yang diunggah mahasiswa)
php artisan storage:link

# 7. Jalankan server lokal
php artisan serve
```

Buka `http://localhost:8000` di browser.

## Fitur

**Autentikasi**

**Beranda Mahasiswa (mobile-style)**

**Jadwal Kuliah** (`/mahasiswa/jadwal`)

**KHS / Kartu Hasil Studi** (`/mahasiswa/khs`)

**Pengisian KRS** (`/mahasiswa/krs`)

**Pembayaran UKT** (`/mahasiswa/ukt`)

**Profil Mahasiswa**

**Pengalaman & Tampilan**

**Dashboard Admin**

## Struktur Folder Penting

```
app/Http/Controllers/Auth/LoginController.php          -> Login & logout
app/Http/Controllers/MahasiswaHomeController.php        -> Beranda, profil (lihat/edit) mahasiswa
app/Http/Controllers/Mahasiswa/JadwalController.php     -> Jadwal kuliah mingguan
app/Http/Controllers/Mahasiswa/KhsController.php        -> Kartu Hasil Studi & IPK
app/Http/Controllers/Mahasiswa/KrsController.php        -> Pengisian/pembatalan KRS
app/Http/Controllers/Mahasiswa/UktController.php        -> Status & simulasi pembayaran UKT
app/Http/Controllers/Admin/DashboardController.php      -> Dashboard admin
app/Http/Controllers/Admin/MahasiswaController.php      -> CRUD data mahasiswa
app/Http/Middleware/AdminMiddleware.php                 -> Proteksi halaman admin
app/Http/Middleware/MahasiswaMiddleware.php              -> Proteksi halaman mahasiswa
app/Models/User.php                                      -> Model akun (role: admin/mahasiswa)
app/Models/Mahasiswa.php                                 -> Data akademik + hitung IPK/SKS otomatis
app/Models/MataKuliah.php                                -> Katalog mata kuliah & jadwal
app/Models/Krs.php                                       -> KRS berjalan sekaligus riwayat KHS
app/Models/Pembayaran.php                                -> Riwayat & status pembayaran UKT
database/migrations/                                     -> Skema seluruh tabel
database/seeders/DatabaseSeeder.php                       -> Data awal (admin, 2 mahasiswa, katalog MK, KRS/KHS, UKT)
resources/views/auth/login.blade.php                      -> Halaman login
resources/views/mahasiswa/                                 -> Beranda, jadwal, khs, krs, ukt, profil (mobile)
resources/views/admin/                                      -> Dashboard & CRUD mahasiswa
resources/views/components/layouts/                          -> Layout guest, mobile (dark mode + toast), admin
routes/web.php                                                -> Semua rute aplikasi
```

## Catatan Penting

- Folder `vendor/` **tidak disertakan** dalam paket ini — jalankan `composer install` untuk mengunduhnya.
- Styling menggunakan **Tailwind CSS via CDN** dan interaktivitas tab/toast/modal memakai **Alpine.js via CDN**, jadi tidak perlu proses build (`npm install`/`npm run build`).
- Jangan lupa jalankan `php artisan storage:link` agar foto profil yang diunggah mahasiswa bisa tampil.
- Untuk deployment produksi, sebaiknya ganti Tailwind CDN dengan build Tailwind lokal via Vite agar lebih ringan dan tanpa ketergantungan internet.
- Password akun contoh di atas hanya untuk demo — segera ganti di lingkungan produksi.

## Menambah Kolom / Fitur Lain

Jika ingin menambah field baru pada data mahasiswa (misalnya foto profil, dosen wali, dll):
1. Tambahkan kolom lewat migration baru: `php artisan make:migration add_kolom_baru_to_mahasiswas_table`
2. Tambahkan nama kolom ke `$fillable` pada `app/Models/Mahasiswa.php`
3. Tambahkan input field di `resources/views/admin/mahasiswa/_form.blade.php`
4. Update validasi di `MahasiswaController::validasi()`
