<?php

namespace App\Models;

use App\Models\Scopes\UserScope; // Import UserScope
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Ujian extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'mata_pelajaran_id',
        'nama_ujian',
        'tanggal_ujian',
        'catatan',
        'lokasi',
        'user_id',
        'is_selesai',
    ];

    /**
     * The attributes that should be cast to native types.
     */
    protected $casts = [
        'tanggal_ujian' => 'datetime',
        'is_selesai' => 'boolean',
    ];

    /**
     * The "booted" method of the model.
     * Menerapkan Global Scope untuk memfilter data berdasarkan user yang login.
     */
    protected static function booted(): void
    {
        static::addGlobalScope(new UserScope);
    }

    /**
     * Relasi ke model MataPelajaran.
     */
    public function mataPelajaran(): BelongsTo
    {
        return $this->belongsTo(MataPelajaran::class);
    }

    /**
     * Relasi ke model User (pemilik data).
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
