<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Mahasiswa;
use App\Models\User;

class DashboardController extends Controller
{
    /**
     * Dashboard utama admin - ringkasan statistik mahasiswa.
     */
    public function index()
    {
        $totalMahasiswa = Mahasiswa::count();
        $totalAktif = Mahasiswa::where('status', 'aktif')->count();
        $totalCuti = Mahasiswa::where('status', 'cuti')->count();
        $totalLulus = Mahasiswa::where('status', 'lulus')->count();

        $perProdi = Mahasiswa::selectRaw('program_studi, COUNT(*) as jumlah')
            ->groupBy('program_studi')
            ->orderByDesc('jumlah')
            ->get();

        $mahasiswaTerbaru = Mahasiswa::latest()->take(5)->get();

        $totalAdmin = User::where('role', 'admin')->count();

        return view('admin.dashboard', compact(
            'totalMahasiswa',
            'totalAktif',
            'totalCuti',
            'totalLulus',
            'perProdi',
            'mahasiswaTerbaru',
            'totalAdmin'
        ));
    }
}
