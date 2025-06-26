<?php

namespace App\Models;

use App\Models\Scopes\UserScope; // Import UserScope
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MataPelajaran extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'nama_mapel',
        'nama_dosen',
        'materi_path',
        'user_id',
    ];

    /**
     * The "booted" method of the model.
     */
    protected static function booted(): void
    {
        static::addGlobalScope(new UserScope);
    }

    /**
     * Relasi ke model User (pemilik data).
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke model Ujian.
     */
    public function ujians(): HasMany
    {
        return $this->hasMany(Ujian::class);
    }

    /**
     * Relasi ke model TipsBelajar.
     */
    public function tipsBelajars(): HasMany
    {
        return $this->hasMany(TipsBelajar::class);
    }
}
