<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Krs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KhsController extends Controller
{
    /**
     * Kartu Hasil Studi: nilai per semester + IPS, dan IPK kumulatif.
     */
    public function index(Request $request)
    {
        $mahasiswa = Auth::user()->mahasiswa;

        $semuaLulus = Krs::with('mataKuliah')
            ->where('mahasiswa_id', $mahasiswa->id)
            ->where('status', 'lulus')
            ->whereNotNull('nilai_bobot')
            ->get()
            ->sortBy('semester_ke')
            ->groupBy('semester_ke');

        $riwayatSemester = $semuaLulus->map(function ($daftar, $semesterKe) {
            $totalSks = $daftar->sum(fn ($k) => $k->mataKuliah->sks ?? 0);
            $totalBobot = $daftar->sum(fn ($k) => ($k->mataKuliah->sks ?? 0) * $k->nilai_bobot);

            return [
                'semester_ke' => $semesterKe,
                'tahun_ajaran' => $daftar->first()->tahun_ajaran,
                'mata_kuliah' => $daftar,
                'sks' => $totalSks,
                'ips' => $totalSks > 0 ? round($totalBobot / $totalSks, 2) : 0,
            ];
        });

        $semesterDipilih = (int) $request->query('semester', $riwayatSemester->keys()->last() ?? 0);
        $detailSemester = $riwayatSemester->get($semesterDipilih);

        return view('mahasiswa.khs', [
            'mahasiswa' => $mahasiswa,
            'riwayatSemester' => $riwayatSemester,
            'semesterDipilih' => $semesterDipilih,
            'detailSemester' => $detailSemester,
            'ipk' => $mahasiswa->hitungIpk(),
            'sksTempuh' => $mahasiswa->hitungSksTempuh(),
        ]);
    }
}
