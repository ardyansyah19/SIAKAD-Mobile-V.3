<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MataKuliah extends Model
{
    use HasFactory;

    protected $table = 'mata_kuliahs';

    protected $fillable = [
        'kode_mk',
        'nama_mk',
        'sks',
        'semester',
        'prodi',
        'dosen',
        'hari',
        'jam_mulai',
        'jam_selesai',
        'ruang',
        'kuota',
    ];

    public function krs()
    {
        return $this->hasMany(Krs::class);
    }

    /**
     * Jumlah mahasiswa yang sudah mengambil MK ini pada tahun ajaran berjalan.
     */
    public function jumlahPeserta(string $tahunAjaran): int
    {
        return $this->krs()->where('tahun_ajaran', $tahunAjaran)->count();
    }

    public function getJamAttribute(): string
    {
        return substr($this->jam_mulai, 0, 5).' - '.substr($this->jam_selesai, 0, 5);
    }
}
