<?php

namespace App\Models;

use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements FilamentUser
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Pastikan casts Anda sudah lengkap seperti ini.
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_admin' => 'boolean', // <-- Ini baris yang paling krusial
        ];
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return true;
    }

    // Semua relasi Anda
    public function mataPelajarans(): HasMany
    {
        return $this->hasMany(MataPelajaran::class);
    }
    public function ujians(): HasMany
    {
        return $this->hasMany(Ujian::class);
    }
    public function tipsBelajars(): HasMany
    {
        return $this->hasMany(TipsBelajar::class);
    }
}
