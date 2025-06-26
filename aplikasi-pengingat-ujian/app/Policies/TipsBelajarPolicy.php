<?php

namespace App\Policies;

use App\Models\TipsBelajar;
use App\Models\User;

class TipsBelajarPolicy
{
    /**
     * Metode bantuan untuk memeriksa apakah user adalah pemilik atau admin.
     */
    private function isAdminOrOwner(User $user, TipsBelajar $tipsBelajar): bool
    {
        return $user->id === $tipsBelajar->user_id || $user->is_admin;
    }

    public function view(User $user, TipsBelajar $tipsBelajar): bool
    {
        return $this->isAdminOrOwner($user, $tipsBelajar);
    }

    public function update(User $user, TipsBelajar $tipsBelajar): bool
    {
        return $this->isAdminOrOwner($user, $tipsBelajar);
    }

    public function delete(User $user, TipsBelajar $tipsBelajar): bool
    {
        return $this->isAdminOrOwner($user, $tipsBelajar);
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
