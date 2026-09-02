<?php

namespace App\Http\Controllers;

use App\Models\Krs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MahasiswaHomeController extends Controller
{
    private const URUTAN_HARI = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];

    /**
     * Beranda mahasiswa (tampilan gaya mobile app).
     */
    public function index()
    {
        $user = Auth::user();
        $mahasiswa = $user->mahasiswa;

        $tahunAjaranAktif = Krs::where('mahasiswa_id', $mahasiswa->id)
            ->where('status', 'diambil')
            ->max('tahun_ajaran');

        $krsAktif = Krs::with('mataKuliah')
            ->where('mahasiswa_id', $mahasiswa->id)
            ->where('status', 'diambil')
            ->when($tahunAjaranAktif, fn ($q) => $q->where('tahun_ajaran', $tahunAjaranAktif))
            ->get();

        $ringkasan = [
            'ipk' => $mahasiswa->hitungIpk(),
            'sks_tempuh' => $mahasiswa->hitungSksTempuh(),
            'sks_total' => 144,
            'semester_berjalan' => $mahasiswa->semester ?? 1,
        ];

        $hariIniIndo = self::URUTAN_HARI[now()->dayOfWeekIso - 1] ?? null;

        $jadwalHariIni = $krsAktif
            ->filter(fn ($k) => $k->mataKuliah->hari === $hariIniIndo)
            ->sortBy(fn ($k) => $k->mataKuliah->jam_mulai)
            ->map(fn ($k) => [
                'mk' => $k->mataKuliah->nama_mk,
                'jam' => $k->mataKuliah->jam,
                'ruang' => $k->mataKuliah->ruang,
            ])
            ->values();

        $pengumuman = [
            ['judul' => 'Pengisian KRS Semester Genap', 'tanggal' => '02 Sep 2026'],
            ['judul' => 'Jadwal UTS telah dirilis', 'tanggal' => '28 Agu 2026'],
            ['judul' => 'Batas akhir pembayaran UKT', 'tanggal' => '15 Sep 2026'],
        ];

        $tagihanBelumLunas = $mahasiswa->pembayarans()->where('status', 'belum_bayar')->exists();

        return view('mahasiswa.beranda', [
            'user' => $user,
            'mahasiswa' => $mahasiswa,
            'ringkasan' => $ringkasan,
            'jadwalHariIni' => $jadwalHariIni,
            'pengumuman' => $pengumuman,
            'sapaan' => $this->sapaanWaktu(),
            'tagihanBelumLunas' => $tagihanBelumLunas,
        ]);
    }

    /**
     * Halaman profil mahasiswa.
     */
    public function profil()
    {
        $user = Auth::user();
        $mahasiswa = $user->mahasiswa;

        return view('mahasiswa.profil', compact('user', 'mahasiswa'));
    }

    /**
     * Form edit profil mahasiswa (data kontak & foto).
     */
    public function editProfil()
    {
        $user = Auth::user();
        $mahasiswa = $user->mahasiswa;

        return view('mahasiswa.profil-edit', compact('user', 'mahasiswa'));
    }

    /**
     * Simpan perubahan profil mahasiswa.
     */
    public function updateProfil(Request $request)
    {
        $mahasiswa = Auth::user()->mahasiswa;

        $data = $request->validate([
            'no_hp' => ['nullable', 'string', 'max:20'],
            'alamat' => ['nullable', 'string', 'max:1000'],
            'jenis_kelamin' => ['nullable', 'in:L,P'],
            'foto' => ['nullable', 'image', 'max:2048'],
        ], [
            'foto.image' => 'File foto harus berupa gambar.',
            'foto.max' => 'Ukuran foto maksimal 2MB.',
        ]);

        if ($request->hasFile('foto')) {
            if ($mahasiswa->foto) {
                Storage::disk('public')->delete($mahasiswa->foto);
            }

            $data['foto'] = $request->file('foto')->store('mahasiswa', 'public');
        }

        $mahasiswa->update($data);

        return redirect()->route('mahasiswa.profil')
            ->with('sukses', 'Profil berhasil diperbarui.');
    }

    /**
     * Sapaan dinamis berdasarkan jam saat ini.
     */
    private function sapaanWaktu(): string
    {
        $jam = now()->hour;

        return match (true) {
            $jam < 10 => 'Selamat pagi,',
            $jam < 15 => 'Selamat siang,',
            $jam < 18 => 'Selamat sore,',
            default => 'Selamat malam,',
        };
    }
}
