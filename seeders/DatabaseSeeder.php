<?php

namespace Database\Seeders;

use App\Models\Krs;
use App\Models\Mahasiswa;
use App\Models\MataKuliah;
use App\Models\Pembayaran;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Akun admin
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@kampus.ac.id',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);

        // Contoh akun mahasiswa
        $dataMahasiswa = [
            [
                'name' => 'Ahmad Riko Dyansyah',
                'email' => 'riko@kampus.ac.id',
                'nim' => '1462400002',
                'program_studi' => 'Teknik Informatika',
                'angkatan' => 2024,
                'semester' => 5,
                'jenis_kelamin' => 'L',
            ],
            [
                'name' => 'Siti Amelia Putri',
                'email' => 'amelia@kampus.ac.id',
                'nim' => '1462400015',
                'program_studi' => 'Sistem Informasi',
                'angkatan' => 2024,
                'semester' => 5,
                'jenis_kelamin' => 'P',
            ],
        ];

        $mahasiswaList = [];

        foreach ($dataMahasiswa as $data) {
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make('mahasiswa123'),
                'role' => 'mahasiswa',
            ]);

            $mahasiswaList[] = Mahasiswa::create([
                'user_id' => $user->id,
                'nim' => $data['nim'],
                'nama' => $data['name'],
                'email' => $data['email'],
                'program_studi' => $data['program_studi'],
                'angkatan' => $data['angkatan'],
                'semester' => $data['semester'],
                'jenis_kelamin' => $data['jenis_kelamin'],
                'status' => 'aktif',
            ]);
        }

        $this->seedAkademik($mahasiswaList);
    }

    /**
     * Seed katalog mata kuliah, riwayat KRS/KHS, dan status UKT untuk demo.
     */
    private function seedAkademik(array $mahasiswaList): void
    {
        $katalog = [
            // Semester 1
            ['TIF101', 'Algoritma dan Pemrograman', 3, 1, 'Teknik Informatika', 'Budi Santoso, S.Kom., M.Kom.', 'Senin', '07:00', '09:30', 'Lab RPL 1'],
            ['TIF102', 'Matematika Diskrit', 3, 1, 'Teknik Informatika', 'Rina Kusuma, S.Si., M.Si.', 'Selasa', '07:00', '09:30', 'GK 101'],
            ['UNI101', 'Pendidikan Agama', 2, 1, null, 'Ahmad Fauzi, S.Ag., M.Pd.', 'Rabu', '07:00', '08:40', 'GK 102'],
            ['UNI102', 'Bahasa Indonesia', 2, 1, null, 'Dewi Lestari, S.Pd., M.Pd.', 'Kamis', '07:00', '08:40', 'GK 103'],
            // Semester 2
            ['TIF201', 'Struktur Data', 3, 2, 'Teknik Informatika', 'Budi Santoso, S.Kom., M.Kom.', 'Senin', '09:30', '12:00', 'Lab RPL 1'],
            ['TIF202', 'Basis Data', 3, 2, 'Teknik Informatika', 'Sari Wulandari, S.Kom., M.T.', 'Selasa', '09:30', '12:00', 'Lab RPL 2'],
            ['TIF203', 'Sistem Digital', 3, 2, 'Teknik Informatika', 'Hendra Gunawan, S.T., M.T.', 'Rabu', '09:00', '11:30', 'Lab Elektro'],
            ['UNI201', 'Kewarganegaraan', 2, 2, null, 'Dewi Lestari, S.Pd., M.Pd.', 'Kamis', '09:00', '10:40', 'GK 103'],
            // Semester 3
            ['TIF301', 'Pemrograman Berorientasi Objek', 3, 3, 'Teknik Informatika', 'Rudi Hartono, S.Kom., M.Kom.', 'Senin', '08:00', '10:30', 'Lab RPL 2'],
            ['TIF302', 'Jaringan Komputer', 3, 3, 'Teknik Informatika', 'Hendra Gunawan, S.T., M.T.', 'Selasa', '08:00', '10:30', 'Lab Jaringan'],
            ['TIF303', 'Sistem Operasi', 3, 3, 'Teknik Informatika', 'Sari Wulandari, S.Kom., M.T.', 'Rabu', '08:00', '10:30', 'Lab RPL 1'],
            ['TIF304', 'Statistika', 2, 3, 'Teknik Informatika', 'Rina Kusuma, S.Si., M.Si.', 'Kamis', '08:00', '09:40', 'GK 201'],
            // Semester 4
            ['TIF401', 'Pemrograman Web', 3, 4, 'Teknik Informatika', 'Budi Santoso, S.Kom., M.Kom.', 'Senin', '10:30', '13:00', 'Lab RPL 1'],
            ['TIF402', 'Rekayasa Perangkat Lunak', 3, 4, 'Teknik Informatika', 'Rudi Hartono, S.Kom., M.Kom.', 'Selasa', '10:30', '13:00', 'Lab RPL 2'],
            ['TIF403', 'Interaksi Manusia dan Komputer', 2, 4, 'Teknik Informatika', 'Sari Wulandari, S.Kom., M.T.', 'Rabu', '10:30', '12:10', 'GK 202'],
            ['TIF404', 'Metodologi Penelitian', 2, 4, null, 'Agus Prasetyo, S.Kom., M.Cs.', 'Kamis', '10:30', '12:10', 'GK 203'],
            // Semester 5 (berjalan)
            ['TIF501', 'Pemrograman Web Lanjut', 3, 5, 'Teknik Informatika', 'Budi Santoso, S.Kom., M.Kom.', 'Senin', '08:00', '09:40', 'Lab RPL 2'],
            ['TIF502', 'Kecerdasan Buatan', 3, 5, 'Teknik Informatika', 'Agus Prasetyo, S.Kom., M.Cs.', 'Selasa', '10:00', '11:40', 'GK 301'],
            ['TIF503', 'Manajemen Proyek TI', 2, 5, 'Teknik Informatika', 'Rudi Hartono, S.Kom., M.Kom.', 'Rabu', '13:00', '14:40', 'GK 205'],
            ['TIF504', 'Keamanan Sistem Informasi', 3, 5, 'Teknik Informatika', 'Hendra Gunawan, S.T., M.T.', 'Kamis', '09:00', '11:30', 'Lab Jaringan'],
            ['TIF505', 'Kewirausahaan', 2, 5, null, 'Dewi Lestari, S.Pd., M.Pd.', 'Jumat', '08:00', '09:40', 'GK 104'],
            // Mata kuliah pilihan / semester atas (belum diambil, untuk pengisian KRS)
            ['TIF506', 'Pemrograman Mobile', 3, 5, 'Teknik Informatika', 'Sari Wulandari, S.Kom., M.T.', 'Jumat', '10:00', '12:30', 'Lab RPL 1'],
            ['TIF601', 'Machine Learning', 3, 6, 'Teknik Informatika', 'Agus Prasetyo, S.Kom., M.Cs.', 'Sabtu', '08:00', '10:30', 'Lab RPL 2'],
            ['TIF602', 'Cloud Computing', 2, 6, 'Teknik Informatika', 'Hendra Gunawan, S.T., M.T.', 'Sabtu', '10:30', '12:10', 'Lab Jaringan'],
        ];

        $mk = [];
        foreach ($katalog as $row) {
            [$kode, $nama, $sks, $semester, $prodi, $dosen, $hari, $jamMulai, $jamSelesai, $ruang] = $row;

            $mk[$kode] = MataKuliah::create([
                'kode_mk' => $kode,
                'nama_mk' => $nama,
                'sks' => $sks,
                'semester' => $semester,
                'prodi' => $prodi,
                'dosen' => $dosen,
                'hari' => $hari,
                'jam_mulai' => $jamMulai,
                'jam_selesai' => $jamSelesai,
                'ruang' => $ruang,
                'kuota' => 40,
            ]);
        }

        $tahunAjaran = [
            1 => '2024/2025 Ganjil',
            2 => '2024/2025 Genap',
            3 => '2025/2026 Ganjil',
            4 => '2025/2026 Genap',
            5 => '2026/2027 Ganjil',
        ];

        // Riwayat KHS (semester 1-4, sudah lulus) + KRS berjalan (semester 5)
        $riwayat = [
            1 => [['TIF101', 'A'], ['TIF102', 'AB'], ['UNI101', 'A'], ['UNI102', 'A']],
            2 => [['TIF201', 'A'], ['TIF202', 'AB'], ['TIF203', 'A'], ['UNI201', 'A']],
            3 => [['TIF301', 'AB'], ['TIF302', 'A'], ['TIF303', 'AB'], ['TIF304', 'A']],
            4 => [['TIF401', 'A'], ['TIF402', 'AB'], ['TIF403', 'A'], ['TIF404', 'B']],
        ];

        $krsBerjalan = ['TIF501', 'TIF502', 'TIF503', 'TIF504', 'TIF505'];

        $uktPerProdi = [
            'Teknik Informatika' => 4500000,
            'Sistem Informasi' => 4200000,
        ];

        foreach ($mahasiswaList as $mahasiswa) {
            // KHS semester 1-4 (lulus, sudah ada nilai)
            foreach ($riwayat as $semesterKe => $daftarMk) {
                foreach ($daftarMk as [$kode, $huruf]) {
                    Krs::create([
                        'mahasiswa_id' => $mahasiswa->id,
                        'mata_kuliah_id' => $mk[$kode]->id,
                        'semester_ke' => $semesterKe,
                        'tahun_ajaran' => $tahunAjaran[$semesterKe],
                        'status' => 'lulus',
                        'nilai_huruf' => $huruf,
                        'nilai_bobot' => Krs::BOBOT_NILAI[$huruf],
                    ]);
                }

                Pembayaran::create([
                    'mahasiswa_id' => $mahasiswa->id,
                    'semester_ke' => $semesterKe,
                    'tahun_ajaran' => $tahunAjaran[$semesterKe],
                    'jumlah' => $uktPerProdi[$mahasiswa->program_studi] ?? 4200000,
                    'status' => 'lunas',
                    'metode' => 'Transfer Bank',
                    'tanggal_bayar' => now()->subMonths((5 - $semesterKe) * 3 + 1),
                ]);
            }

            // KRS semester berjalan (belum ada nilai)
            foreach ($krsBerjalan as $kode) {
                Krs::create([
                    'mahasiswa_id' => $mahasiswa->id,
                    'mata_kuliah_id' => $mk[$kode]->id,
                    'semester_ke' => 5,
                    'tahun_ajaran' => $tahunAjaran[5],
                    'status' => 'diambil',
                ]);
            }

            // UKT semester berjalan belum dibayar (agar fitur pembayaran ada gunanya)
            Pembayaran::create([
                'mahasiswa_id' => $mahasiswa->id,
                'semester_ke' => 5,
                'tahun_ajaran' => $tahunAjaran[5],
                'jumlah' => $uktPerProdi[$mahasiswa->program_studi] ?? 4200000,
                'status' => 'belum_bayar',
                'metode' => null,
                'tanggal_bayar' => null,
            ]);
        }
    }
}
