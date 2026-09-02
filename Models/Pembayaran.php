<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    use HasFactory;

    protected $table = 'pembayarans';

    protected $fillable = [
        'mahasiswa_id',
        'semester_ke',
        'tahun_ajaran',
        'jumlah',
        'status',
        'metode',
        'tanggal_bayar',
    ];

    protected $casts = [
        'tanggal_bayar' => 'datetime',
        'jumlah' => 'decimal:2',
    ];

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class);
    }
}
