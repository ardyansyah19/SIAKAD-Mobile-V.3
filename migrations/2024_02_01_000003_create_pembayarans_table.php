<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pembayarans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mahasiswa_id')->constrained('mahasiswas')->cascadeOnDelete();
            $table->unsignedTinyInteger('semester_ke');
            $table->string('tahun_ajaran');
            $table->decimal('jumlah', 12, 2);
            $table->enum('status', ['lunas', 'belum_bayar'])->default('belum_bayar');
            $table->string('metode')->nullable();
            $table->timestamp('tanggal_bayar')->nullable();
            $table->timestamps();

            $table->unique(['mahasiswa_id', 'tahun_ajaran'], 'ukt_unik_per_tahun_ajaran');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pembayarans');
    }
};
