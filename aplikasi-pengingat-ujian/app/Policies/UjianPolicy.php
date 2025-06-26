<?php

namespace App\Policies;

use App\Models\Ujian;
use App\Models\User;

class UjianPolicy
{
    private function isAdminOrOwner(User $user, Ujian $ujian): bool
    {
        // Pastikan user admin Anda di database kolom 'is_admin'-nya bernilai 1
        return $user->id === $ujian->user_id || $user->is_admin;
    }

    public function view(User $user, Ujian $ujian): bool    { return $this->isAdminOrOwner($user, $ujian); }
    public function update(User $user, Ujian $ujian): bool  { return $this->isAdminOrOwner($user, $ujian); }
    public function delete(User $user, Ujian $ujian): bool  { return $this->isAdminOrOwner($user, $ujian); }
    
    // Izinkan semua user yang login untuk melihat daftar dan membuat ujian
    public function viewAny(User $user): bool { return true; }
    public function create(User $user): bool { return true; }
}