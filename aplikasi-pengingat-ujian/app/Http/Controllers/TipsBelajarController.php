<?php

namespace App\Http\Controllers;

use App\Models\TipsBelajar;
use App\Models\Scopes\UserScope;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TipsBelajarController extends Controller
{
    /**
     * Menampilkan halaman daftar tips belajar.
     */
    public function index(): View
    {
        // Ambil SEMUA tips belajar, abaikan scope user untuk kasus ini
        // agar mahasiswa bisa melihat semua tips yang di-upload admin.
        // Muat juga relasi mataPelajaran untuk ditampilkan
        $tips = TipsBelajar::withoutGlobalScope(UserScope::class)
            ->with('mataPelajaran')
            ->latest()
            ->get();

        // Kirim data ke view 'tips.index'
        return view('tips.index', ['tips' => $tips]);
    }
}
