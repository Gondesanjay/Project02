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
        Schema::table('ujians', function (Blueprint $table) {
        // Tambah kolom boolean 'is_selesai', defaultnya false (belum selesai)
        $table->boolean('is_selesai')->default(false)->after('catatan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ujians', function (Blueprint $table) {
            //
        });
    }
};
