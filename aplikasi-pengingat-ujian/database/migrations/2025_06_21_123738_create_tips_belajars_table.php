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
        Schema::create('tips_belajars', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->longText('konten');
            
            // Kolom relasi ke mata pelajaran, boleh kosong (nullable)
            // Karena mungkin ada tips yang bersifat umum
            $table->foreignId('mata_pelajaran_id')->nullable()->constrained('mata_pelajarans')->onDelete('set null');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tips_belajars');
    }
};
