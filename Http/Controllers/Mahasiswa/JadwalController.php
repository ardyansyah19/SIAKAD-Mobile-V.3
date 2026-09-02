<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Krs;
use Illuminate\Support\Facades\Auth;

class JadwalController extends Controller
{
    private const URUTAN_HARI = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];

    /**
     * Jadwal kuliah mingguan mahasiswa, diambil dari KRS semester berjalan.
     */
    public function index()
    {
        $mahasiswa = Auth::user()->mahasiswa;

        $tahunAjaranAktif = Krs::where('mahasiswa_id', $mahasiswa->id)
            ->where('status', 'diambil')
            ->max('tahun_ajaran');

        $krsAktif = Krs::with('mataKuliah')
            ->where('mahasiswa_id', $mahasiswa->id)
            ->where('status', 'diambil')
            ->when($tahunAjaranAktif, fn ($q) => $q->where('tahun_ajaran', $tahunAjaranAktif))
            ->get();

        $jadwalPerHari = $krsAktif
            ->sortBy(fn ($k) => $k->mataKuliah->jam_mulai)
            ->groupBy(fn ($k) => $k->mataKuliah->hari)
            ->sortBy(fn ($item, $hari) => array_search($hari, self::URUTAN_HARI));

        $totalSks = $krsAktif->sum(fn ($k) => $k->mataKuliah->sks ?? 0);
        $hariIniIndo = self::URUTAN_HARI[now()->dayOfWeekIso - 1] ?? null;

        return view('mahasiswa.jadwal', [
            'jadwalPerHari' => $jadwalPerHari,
            'urutanHari' => self::URUTAN_HARI,
            'totalSks' => $totalSks,
            'totalMataKuliah' => $krsAktif->count(),
            'tahunAjaranAktif' => $tahunAjaranAktif,
            'hariIniIndo' => $hariIniIndo,
        ]);
    }
}
