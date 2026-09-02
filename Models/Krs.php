<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Krs extends Model
{
    use HasFactory;

    protected $table = 'krs';

    protected $fillable = [
        'mahasiswa_id',
        'mata_kuliah_id',
        'semester_ke',
        'tahun_ajaran',
        'status',
        'nilai_huruf',
        'nilai_bobot',
    ];

    /**
     * Konversi nilai huruf ke bobot (skala 4.00), dipakai untuk hitung IPS/IPK.
     */
    public const BOBOT_NILAI = [
        'A' => 4.00,
        'AB' => 3.50,
        'B' => 3.00,
        'BC' => 2.50,
        'C' => 2.00,
        'D' => 1.00,
        'E' => 0.00,
    ];

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class);
    }

    public function mataKuliah()
    {
        return $this->belongsTo(MataKuliah::class);
    }
}
