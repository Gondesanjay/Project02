<?php

namespace App\Http\Controllers;

use App\Models\Ujian;
use App\Models\Scopes\UserScope;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StudentDashboardController extends Controller
{
    public function index(): View
    {
        // Query dasar yang akan kita modifikasi
        $ujiansQuery = Ujian::with(['mataPelajaran' => function ($query) {
            $query->withoutGlobalScope(UserScope::class);
        }]);

        // --- INI PERBAIKAN LOGIKANYA ---
        // Ambil 1 ujian terdekat yang BELUM SELESAI dan akan datang DI MASA DEPAN
        $ujianSelanjutnya = (clone $ujiansQuery)
            ->where('is_selesai', false)
            ->where('tanggal_ujian', '>=', now()) // <-- Hanya ambil ujian mulai dari sekarang
            ->orderBy('tanggal_ujian', 'asc')    // Urutkan dari yang paling dekat
            ->first();

        // Hitung total ujian yang sudah selesai
        $totalUjianSelesai = Ujian::where('is_selesai', true)->count();

        // Kirim data ke view dashboard
        return view('dashboard', [
            'ujianSelanjutnya' => $ujianSelanjutnya,
            'totalUjianSelesai' => $totalUjianSelesai,
        ]);
    }
}
