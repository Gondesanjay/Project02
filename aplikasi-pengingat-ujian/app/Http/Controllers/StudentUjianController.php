<?php

namespace App\Http\Controllers;

// Import semua class yang dibutuhkan
use App\Models\MataPelajaran;
use App\Models\Scopes\UserScope;
use App\Models\Ujian;
use App\Models\User;
use App\Notifications\UjianBaruDibuatNotification;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Illuminate\View\View;

class StudentUjianController extends Controller
{
    use AuthorizesRequests;

    public function index(Request $request): View
    {
        // Logika index tetap sama
        $filter = $request->query('filter');
        $ujiansQuery = Ujian::with(['mataPelajaran' => fn($q) => $q->withoutGlobalScope(UserScope::class)]);
        if ($filter === 'selesai') $ujiansQuery->where('is_selesai', true);
        elseif ($filter === 'akan-datang') $ujiansQuery->where('is_selesai', false);
        $ujians = $ujiansQuery->latest('tanggal_ujian')->get();
        return view('ujians.index', ['ujians' => $ujians]);
    }

    public function create(): View
    {
        // Logika create tetap sama
        $this->authorize('create', Ujian::class);
        $mataPelajarans = MataPelajaran::withoutGlobalScope(UserScope::class)->orderBy('nama_mapel')->get();
        return view('ujians.create', ['mataPelajarans' => $mataPelajarans]);
    }

    public function store(Request $request): RedirectResponse
    {
        // Logika store tetap sama, dengan tambahan notifikasi
        $this->authorize('create', Ujian::class);
        $validated = $request->validate([
            'mata_pelajaran_id' => 'required|exists:mata_pelajarans,id',
            'nama_ujian' => 'required|string|max:255',
            'lokasi' => 'nullable|string|max:255',
            'tanggal_ujian' => 'required|date',
            'catatan' => 'nullable|string',
        ]);
        $validated['user_id'] = Auth::id();
        $ujianBaru = Ujian::create($validated);

        $admins = User::where('is_admin', true)->get();
        if ($admins->isNotEmpty()) {
            Notification::send($admins, new UjianBaruDibuatNotification($ujianBaru, auth()->user()));
        }

        return redirect()->route('ujian.index')->with('success', 'Jadwal ujian berhasil ditambahkan!');
    }

    public function show(string $id): View
    {
        $ujian = Ujian::withoutGlobalScope(UserScope::class)->findOrFail($id);
        $this->authorize('view', $ujian);
        $ujian->load(['mataPelajaran' => fn($q) => $q->withoutGlobalScope(UserScope::class)]);
        return view('ujians.show', ['ujian' => $ujian]);
    }

    public function edit(string $id): View
    {
        $ujian = Ujian::withoutGlobalScope(UserScope::class)->findOrFail($id);
        $this->authorize('update', $ujian);
        $mataPelajarans = MataPelajaran::withoutGlobalScope(UserScope::class)->orderBy('nama_mapel')->get();
        return view('ujians.edit', ['ujian' => $ujian, 'mataPelajarans' => $mataPelajarans]);
    }

    public function update(Request $request, string $id): RedirectResponse
    {
        $ujian = Ujian::withoutGlobalScope(UserScope::class)->findOrFail($id);
        $this->authorize('update', $ujian);
        $validated = $request->validate([
            'mata_pelajaran_id' => 'required|exists:mata_pelajarans,id',
            'nama_ujian' => 'required|string|max:255',
            'lokasi' => 'nullable|string|max:255',
            'tanggal_ujian' => 'required|date',
            'catatan' => 'nullable|string',
        ]);
        $ujian->update($validated);
        return redirect()->route('ujian.index')->with('success', 'Jadwal ujian berhasil diperbarui.');
    }

    public function destroy(string $id): RedirectResponse
    {
        $ujian = Ujian::withoutGlobalScope(UserScope::class)->findOrFail($id);
        $this->authorize('delete', $ujian);
        $ujian->delete();
        return redirect()->route('ujian.index')->with('success', 'Jadwal ujian berhasil dihapus.');
    }

    public function tandaiSelesai(string $id): RedirectResponse
    {
        $ujian = Ujian::withoutGlobalScope(UserScope::class)->findOrFail($id);
        $this->authorize('update', $ujian);
        $ujian->is_selesai = true;
        $ujian->save();
        return redirect()->route('ujian.index')->with('success', 'Selamat! Ujian telah ditandai sebagai selesai.');
    }
}
