<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('krs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mahasiswa_id')->constrained('mahasiswas')->cascadeOnDelete();
            $table->foreignId('mata_kuliah_id')->constrained('mata_kuliahs')->cascadeOnDelete();
            $table->unsignedTinyInteger('semester_ke'); // semester ke berapa mahasiswa saat mengambil MK ini
            $table->string('tahun_ajaran'); // contoh: 2026/2027 Ganjil
            $table->enum('status', ['diambil', 'lulus'])->default('diambil');
            $table->string('nilai_huruf', 2)->nullable(); // A, AB, B, BC, C, D, E
            $table->decimal('nilai_bobot', 3, 2)->nullable(); // 0.00 - 4.00
            $table->timestamps();

            $table->unique(['mahasiswa_id', 'mata_kuliah_id', 'tahun_ajaran'], 'krs_unik_per_tahun_ajaran');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('krs');
    }
};
