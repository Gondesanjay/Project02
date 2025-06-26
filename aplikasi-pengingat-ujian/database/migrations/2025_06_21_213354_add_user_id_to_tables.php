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
        // Dikosongkan.
        // Seluruh logika dari file ini telah dipindahkan ke dalam file migrasi create
        // untuk masing-masing tabel (mata_pelajarans, ujians, tips_belajars)
        // agar riwayat database lebih bersih dan terpusat.
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Dikosongkan.
    }
};
