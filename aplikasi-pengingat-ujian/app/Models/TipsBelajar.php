<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TipsBelajar extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'judul',
        'konten',
        'mata_pelajaran_id', // Foreign key untuk relasi
    ];

    /**
     * Mendefinisikan relasi ke model MataPelajaran.
     * Satu 'Tips Belajar' dimiliki oleh satu (Belongs To) 'Mata Pelajaran'.
     */
    public function mataPelajaran(): BelongsTo
    {
        return $this->belongsTo(MataPelajaran::class);
    }
}