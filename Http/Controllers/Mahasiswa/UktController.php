<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Pembayaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UktController extends Controller
{
    /**
     * Status & riwayat pembayaran UKT mahasiswa.
     */
    public function index()
    {
        $mahasiswa = Auth::user()->mahasiswa;

        $riwayat = Pembayaran::where('mahasiswa_id', $mahasiswa->id)
            ->orderByDesc('semester_ke')
            ->get();

        $tagihanBerjalan = $riwayat->firstWhere('status', 'belum_bayar');
        $totalLunas = $riwayat->where('status', 'lunas')->sum('jumlah');

        return view('mahasiswa.ukt', [
            'mahasiswa' => $mahasiswa,
            'riwayat' => $riwayat,
            'tagihanBerjalan' => $tagihanBerjalan,
            'totalLunas' => $totalLunas,
        ]);
    }

    /**
     * Simulasi pembayaran UKT (demo, tanpa gateway pembayaran sungguhan).
     */
    public function store(Request $request, Pembayaran $pembayaran)
    {
        $mahasiswa = Auth::user()->mahasiswa;

        if ($pembayaran->mahasiswa_id !== $mahasiswa->id || $pembayaran->status !== 'belum_bayar') {
            abort(403);
        }

        $request->validate([
            'metode' => ['required', 'in:Transfer Bank,Virtual Account,E-Wallet'],
        ], [
            'metode.required' => 'Pilih metode pembayaran terlebih dahulu.',
        ]);

        $pembayaran->update([
            'status' => 'lunas',
            'metode' => $request->input('metode'),
            'tanggal_bayar' => now(),
        ]);

        return redirect()->route('mahasiswa.ukt')
            ->with('sukses', 'Pembayaran UKT semester '.$pembayaran->semester_ke.' berhasil dikonfirmasi. Terima kasih!');
    }
}
