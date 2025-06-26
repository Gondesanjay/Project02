<?php

namespace App\Http\Controllers;

use App\Models\MataPelajaran;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class MataPelajaranController extends Controller
{
    public function create(): View
    {
        return view('matapelajaran.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validatedData = $request->validate([
            'nama_mapel' => 'required|string|max:255',
            'nama_dosen' => 'nullable|string|max:255',
            'materi_path' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
        ]);

        $validatedData['user_id'] = Auth::id();

        // DEBUGGING: Tampilkan data dan hentikan eksekusi di sini
        dd('DI DALAM CONTROLLER', $validatedData);

        // Handle file upload jika ada
        if ($request->hasFile('materi_path')) {
            $validatedData['materi_path'] = $request->file('materi_path')->store('materi-pelajaran', 'public');
        }

        MataPelajaran::create($validatedData);

        return redirect()->route('dashboard')->with('success', 'Mata Pelajaran berhasil dibuat!');
    }
}
