<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('mata_pelajarans', function (Blueprint $table) {
            $table->id();

            // Relasi ke tabel users (siapa yang membuat mata pelajaran ini)
            // Kolom ini wajib diisi, tidak nullable.
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();

            // Kolom untuk data utama
            $table->string('nama_mapel'); // Nama mata pelajaran, cth: "Matematika Lanjut"
            $table->string('nama_dosen')->nullable(); // Nama guru atau dosen, boleh kosong

            // Kolom untuk menyimpan path file materi yang di-upload
            $table->string('materi_path')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mata_pelajarans');
    }
};
