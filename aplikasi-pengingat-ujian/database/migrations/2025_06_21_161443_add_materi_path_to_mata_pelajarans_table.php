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
        Schema::table('mata_pelajarans', function (Blueprint $table) {
        // Menambahkan kolom baru untuk menyimpan path file materi
        // nullable() berarti kolom ini boleh kosong (tidak semua mapel wajib punya materi)
        $table->string('materi_path')->nullable()->after('nama_dosen');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mata_pelajarans', function (Blueprint $table) {
            //
        });
    }
};
