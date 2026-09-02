# Sistem Login & Manajemen Data Mahasiswa (Laravel)

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

## Akun Demo (hasil seeder)

| Peran     | Email                  | Password      |
|-----------|-------------------------|----------------|
| Admin     | admin@kampus.ac.id      | admin123       |
| Mahasiswa | riko@kampus.ac.id       | mahasiswa123   |
| Mahasiswa | amelia@kampus.ac.id     | mahasiswa123   |

## Fitur

**Autentikasi**
- Login satu form untuk semua role, validasi & pesan error dalam Bahasa Indonesia
- Middleware kustom `admin` dan `mahasiswa` untuk membatasi akses halaman sesuai peran
- Logout aman dengan regenerasi session & token CSRF

**Beranda Mahasiswa (mobile-style)**
- Bingkai tampilan menyerupai aplikasi HP (max-width 448px, bottom navigation dengan 5 menu aktif)
- Sapaan dinamis sesuai jam (pagi/siang/sore/malam)
- Kartu ringkasan IPK & SKS tempuh **dihitung otomatis dari data KRS/nilai riil**, bukan lagi angka statis
- Menu cepat (KRS, KHS, Jadwal, UKT) — semuanya sudah tersambung ke halaman fungsional
- Notifikasi banner otomatis jika ada tagihan UKT yang belum lunas
- Jadwal kuliah hari ini (real-time sesuai hari berjalan) & daftar pengumuman

**Jadwal Kuliah** (`/mahasiswa/jadwal`)
- Jadwal mingguan per hari (tab Senin–Sabtu) diambil dari KRS semester aktif
- Total SKS & jumlah mata kuliah semester berjalan

**KHS / Kartu Hasil Studi** (`/mahasiswa/khs`)
- Riwayat nilai per semester dengan IPS masing-masing semester
- IPK kumulatif dihitung otomatis dari seluruh mata kuliah yang sudah lulus
- Navigasi antar semester tanpa reload halaman

**Pengisian KRS** (`/mahasiswa/krs`)
- Tambah/batalkan mata kuliah untuk semester berjalan
- Meteran total SKS dengan batas maksimal (24 SKS)
- Validasi otomatis: mencegah SKS melebihi batas & mencegah jadwal bentrok (hari & jam sama)

**Pembayaran UKT** (`/mahasiswa/ukt`)
- Status tagihan semester berjalan + riwayat pembayaran semester sebelumnya
- Simulasi pembayaran (pilih metode: Transfer Bank / Virtual Account / E-Wallet)

**Profil Mahasiswa**
- Lihat data akademik lengkap + edit data kontak (no. HP, alamat, jenis kelamin) dan unggah foto profil
- Toggle **mode gelap** yang tersimpan otomatis di perangkat (localStorage)

**Pengalaman & Tampilan**
- Mode gelap (dark mode) di seluruh halaman mahasiswa, tersimpan per perangkat
- Notifikasi toast (sukses/gagal) untuk setiap aksi (tambah/batal KRS, bayar UKT, update profil)
- Navigasi antar tab tanpa reload halaman (Alpine.js) untuk jadwal, KHS, dan KRS
- Halaman profil mahasiswa dengan data akademik lengkap

**Dashboard Admin**
- Statistik total mahasiswa, aktif, cuti, dan lulus
- Grafik proporsi mahasiswa per program studi
- Tabel mahasiswa terbaru
- **CRUD Data Mahasiswa**: tambah, lihat detail, edit, hapus
- Pencarian (NIM/nama/email) dan filter status
- Setiap mahasiswa baru otomatis mendapat akun login (`role: mahasiswa`)

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
