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
        Schema::create('ujians', function (Blueprint $table) {
            $table->id();

            // Kolom relasi (foreign keys)
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('mata_pelajaran_id')->constrained('mata_pelajarans')->cascadeOnDelete();

            // Kolom untuk data utama
            $table->string('nama_ujian'); // Contoh: "Ujian Tengah Semester", "Kuis 2"
            $table->dateTime('tanggal_ujian'); // Tanggal dan waktu ujian
            $table->text('catatan')->nullable(); // Catatan tambahan, boleh kosong

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ujians');
    }
};
