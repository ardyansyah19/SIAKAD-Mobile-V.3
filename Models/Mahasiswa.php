<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    use HasFactory;

    protected $table = 'mahasiswas';

    protected $fillable = [
        'user_id',
        'nim',
        'nama',
        'email',
        'program_studi',
        'fakultas',
        'angkatan',
        'semester',
        'no_hp',
        'alamat',
        'jenis_kelamin',
        'status',      // aktif | cuti | lulus | dropout
        'foto',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function krs()
    {
        return $this->hasMany(Krs::class);
    }

    public function pembayarans()
    {
        return $this->hasMany(Pembayaran::class);
    }

    /**
     * Hitung IPK kumulatif dari seluruh mata kuliah berstatus "lulus".
     */
    public function hitungIpk(): float
    {
        $lulus = $this->krs()->with('mataKuliah')->where('status', 'lulus')->whereNotNull('nilai_bobot')->get();

        $totalSks = $lulus->sum(fn ($k) => $k->mataKuliah->sks ?? 0);
        $totalBobot = $lulus->sum(fn ($k) => ($k->mataKuliah->sks ?? 0) * $k->nilai_bobot);

        return $totalSks > 0 ? round($totalBobot / $totalSks, 2) : 0.0;
    }

    /**
     * Total SKS yang sudah lulus (SKS tempuh).
     */
    public function hitungSksTempuh(): int
    {
        return (int) $this->krs()->with('mataKuliah')->where('status', 'lulus')
            ->get()
            ->sum(fn ($k) => $k->mataKuliah->sks ?? 0);
    }
}
