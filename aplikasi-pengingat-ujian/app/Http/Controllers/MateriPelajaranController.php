<?php

namespace App\Http\Controllers;

use App\Models\MataPelajaran;
use App\Models\Scopes\UserScope;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MateriPelajaranController extends Controller
{
    /**
     * Menampilkan halaman daftar materi pelajaran dengan fungsionalitas pencarian.
     */
    public function index(Request $request): View
    {
        // Ambil kata kunci pencarian dari URL
        $search = $request->query('search');

        // Mulai query dasar
        $query = MataPelajaran::withoutGlobalScope(UserScope::class);

        // Terapkan kondisi pencarian HANYA JIKA ada input dari user
        $query->when($search, function ($query, $searchTerm) {
            // Cari di kolom 'nama_mapel' ATAU 'nama_dosen'
            // yang mengandung kata kunci pencarian
            $query->where('nama_mapel', 'like', "%{$searchTerm}%")
                ->orWhere('nama_dosen', 'like', "%{$searchTerm}%");
        });

        // Ambil data setelah query dimodifikasi
        $mataPelajarans = $query->orderBy('nama_mapel')->get();

        // Kirim data ke view 'materi.index'
        return view('materi.index', ['mataPelajarans' => $mataPelajarans]);
    }
}
