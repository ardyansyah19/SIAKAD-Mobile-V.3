<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Krs;
use App\Models\MataKuliah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KrsController extends Controller
{
    private const MAKS_SKS = 24;

    private const URUTAN_HARI = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];

    /**
     * Halaman pengisian KRS: daftar MK yang sudah diambil + MK yang tersedia untuk ditambah.
     */
    public function index()
    {
        $mahasiswa = Auth::user()->mahasiswa;
        $tahunAjaranAktif = $this->tahunAjaranAktif($mahasiswa);

        $krsAktif = Krs::with('mataKuliah')
            ->where('mahasiswa_id', $mahasiswa->id)
            ->where('status', 'diambil')
            ->where('tahun_ajaran', $tahunAjaranAktif)
            ->get()
            ->sortBy(fn ($k) => sprintf('%d-%s', array_search($k->mataKuliah->hari, self::URUTAN_HARI), $k->mataKuliah->jam_mulai));

        $totalSks = $krsAktif->sum(fn ($k) => $k->mataKuliah->sks ?? 0);

        $idSudahDiambilAtauLulus = Krs::where('mahasiswa_id', $mahasiswa->id)
            ->whereIn('status', ['diambil', 'lulus'])
            ->pluck('mata_kuliah_id');

        $mataKuliahTersedia = MataKuliah::whereNotIn('id', $idSudahDiambilAtauLulus)
            ->where('semester', '<=', $mahasiswa->semester + 1)
            ->orderBy('semester')
            ->orderByRaw("FIELD(hari, 'Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu')")
            ->orderBy('jam_mulai')
            ->get();

        return view('mahasiswa.krs', [
            'mahasiswa' => $mahasiswa,
            'krsAktif' => $krsAktif,
            'totalSks' => $totalSks,
            'maksSks' => self::MAKS_SKS,
            'mataKuliahTersedia' => $mataKuliahTersedia,
            'tahunAjaranAktif' => $tahunAjaranAktif,
        ]);
    }

    /**
     * Tambahkan satu mata kuliah ke KRS berjalan.
     */
    public function store(Request $request)
    {
        $mahasiswa = Auth::user()->mahasiswa;
        $tahunAjaranAktif = $this->tahunAjaranAktif($mahasiswa);

        $request->validate([
            'mata_kuliah_id' => ['required', 'exists:mata_kuliahs,id'],
        ], [
            'mata_kuliah_id.required' => 'Pilih mata kuliah terlebih dahulu.',
            'mata_kuliah_id.exists' => 'Mata kuliah tidak ditemukan.',
        ]);

        $mataKuliah = MataKuliah::findOrFail($request->input('mata_kuliah_id'));

        $sudahDiambil = Krs::where('mahasiswa_id', $mahasiswa->id)
            ->where('mata_kuliah_id', $mataKuliah->id)
            ->whereIn('status', ['diambil', 'lulus'])
            ->exists();

        if ($sudahDiambil) {
            return back()->with('gagal', 'Mata kuliah ini sudah pernah diambil.');
        }

        $krsAktif = Krs::with('mataKuliah')
            ->where('mahasiswa_id', $mahasiswa->id)
            ->where('status', 'diambil')
            ->where('tahun_ajaran', $tahunAjaranAktif)
            ->get();

        $totalSks = $krsAktif->sum(fn ($k) => $k->mataKuliah->sks ?? 0);

        if ($totalSks + $mataKuliah->sks > self::MAKS_SKS) {
            return back()->with('gagal', "Gagal menambah {$mataKuliah->nama_mk}: melebihi batas maksimal ".self::MAKS_SKS.' SKS.');
        }

        $bentrok = $krsAktif->first(fn ($k) => $k->mataKuliah->hari === $mataKuliah->hari
            && $k->mataKuliah->jam_mulai < $mataKuliah->jam_selesai
            && $mataKuliah->jam_mulai < $k->mataKuliah->jam_selesai);

        if ($bentrok) {
            return back()->with('gagal', "Jadwal {$mataKuliah->nama_mk} bentrok dengan {$bentrok->mataKuliah->nama_mk} pada hari {$mataKuliah->hari}.");
        }

        Krs::create([
            'mahasiswa_id' => $mahasiswa->id,
            'mata_kuliah_id' => $mataKuliah->id,
            'semester_ke' => $mahasiswa->semester,
            'tahun_ajaran' => $tahunAjaranAktif,
            'status' => 'diambil',
        ]);

        return back()->with('sukses', "{$mataKuliah->nama_mk} berhasil ditambahkan ke KRS.");
    }

    /**
     * Batalkan (drop) satu mata kuliah dari KRS berjalan.
     */
    public function destroy(Krs $krs)
    {
        $mahasiswa = Auth::user()->mahasiswa;

        if ($krs->mahasiswa_id !== $mahasiswa->id || $krs->status !== 'diambil') {
            abort(403);
        }

        $nama = $krs->mataKuliah->nama_mk;
        $krs->delete();

        return back()->with('sukses', "{$nama} berhasil dibatalkan dari KRS.");
    }

    /**
     * Tahun ajaran yang sedang berjalan untuk mahasiswa ini.
     */
    private function tahunAjaranAktif(\App\Models\Mahasiswa $mahasiswa): string
    {
        return Krs::where('mahasiswa_id', $mahasiswa->id)
            ->where('status', 'diambil')
            ->max('tahun_ajaran')
            ?? now()->year.'/'.(now()->year + 1).' Ganjil';
    }
}
