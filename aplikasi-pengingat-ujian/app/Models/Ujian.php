<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Ujian extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     * Atribut yang boleh diisi secara massal melalui form.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'mata_pelajaran_id',
        'nama_ujian',
        'tanggal_ujian',
        'catatan',
        'is_selesai',
    ];

    /**
     * The attributes that should be cast to native types.
     * Mengubah tipe data atribut secara otomatis.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'tanggal_ujian' => 'datetime',
        'is_selesai' => 'boolean', // Ini adalah perbaikan untuk error 'diffForHumans()'
    ];

    /**
     * Mendefinisikan relasi ke model MataPelajaran.
     * Satu Ujian dimiliki oleh (Belongs To) satu MataPelajaran.
     */
    public function mataPelajaran(): BelongsTo
    {
        return $this->belongsTo(MataPelajaran::class);
    }
}
