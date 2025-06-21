<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany; // Kita perlu ini untuk relasi

class MataPelajaran extends Model
{
    use HasFactory;

    /**
     * Properti $fillable untuk mengizinkan Mass Assignment.
     * Ini WAJIB ada agar form create/edit bisa berfungsi.
     */
    protected $fillable = [
        'nama_mapel',
        'nama_dosen',
        'materi_path',
    ];

    /**
     * Mendefinisikan relasi ke model Ujian.
     * Satu MataPelajaran bisa memiliki banyak Ujian.
     */
    public function ujians(): HasMany
    {
        // Pastikan Anda sudah memiliki model Ujian di app/Models/Ujian.php
        return $this->hasMany(Ujian::class);
    }

    public function tipsBelajar(): HasMany
    {
        return $this->hasMany(TipsBelajar::class);
    }
}
