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
