<?php

namespace App\Policies;

use App\Models\MataPelajaran;
use App\Models\User;

class MataPelajaranPolicy
{
    /**
     * Metode bantuan untuk memeriksa apakah user adalah pemilik atau admin.
     */
    private function isAdminOrOwner(User $user, MataPelajaran $mataPelajaran): bool
    {
        return $user->id === $mataPelajaran->user_id || $user->is_admin;
    }

    public function view(User $user, MataPelajaran $mataPelajaran): bool
    {
        return $this->isAdminOrOwner($user, $mataPelajaran);
    }

    public function update(User $user, MataPelajaran $mataPelajaran): bool
    {
        return $this->isAdminOrOwner($user, $mataPelajaran);
    }

    public function delete(User $user, MataPelajaran $mataPelajaran): bool
    {
        return $this->isAdminOrOwner($user, $mataPelajaran);
    }

    // Izinkan semua user yang login untuk melihat daftar dan membuat data baru.
    public function viewAny(User $user): bool
    {
        return true;
    }
    public function create(User $user): bool
    {
        return true;
    }
}
