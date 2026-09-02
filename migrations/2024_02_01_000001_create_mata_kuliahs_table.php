<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mata_kuliahs', function (Blueprint $table) {
            $table->id();
            $table->string('kode_mk')->unique();
            $table->string('nama_mk');
            $table->unsignedTinyInteger('sks');
            $table->unsignedTinyInteger('semester'); // semester rekomendasi (1-8)
            $table->string('prodi')->nullable(); // null = berlaku untuk semua prodi
            $table->string('dosen');
            $table->enum('hari', ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu']);
            $table->time('jam_mulai');
            $table->time('jam_selesai');
            $table->string('ruang');
            $table->unsignedSmallInteger('kuota')->default(40);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mata_kuliahs');
    }
};
