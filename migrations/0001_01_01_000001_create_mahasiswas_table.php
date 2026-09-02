<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mahasiswas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('nim')->unique();
            $table->string('nama');
            $table->string('email')->unique();
            $table->string('program_studi');
            $table->string('fakultas')->default('Fakultas Teknologi Elektro dan Informatika Cerdas');
            $table->year('angkatan');
            $table->unsignedTinyInteger('semester')->default(1);
            $table->string('no_hp', 20)->nullable();
            $table->text('alamat')->nullable();
            $table->enum('jenis_kelamin', ['L', 'P'])->nullable();
            $table->enum('status', ['aktif', 'cuti', 'lulus', 'dropout'])->default('aktif');
            $table->string('foto')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mahasiswas');
    }
};
