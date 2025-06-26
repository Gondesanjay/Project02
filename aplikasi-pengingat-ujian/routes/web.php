<?php

use App\Http\Controllers\KalenderController;
use App\Http\Controllers\MataPelajaranController;
use App\Http\Controllers\MateriPelajaranController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentDashboardController;
use App\Http\Controllers\StudentUjianController;
use App\Http\Controllers\TipsBelajarController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [StudentDashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])->name('dashboard');

// Grup untuk semua route yang memerlukan login
Route::middleware('auth')->group(function () {
    // Route untuk manajemen profil user
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Route untuk Mata Pelajaran (CRUD lengkap)
    Route::resource('matapelajaran', MataPelajaranController::class);

    // --- INI PERBAIKANNYA: Menjabarkan Route Ujian Secara Manual ---
    Route::get('/ujian', [StudentUjianController::class, 'index'])->name('ujian.index');
    Route::get('/ujian/create', [StudentUjianController::class, 'create'])->name('ujian.create');
    Route::post('/ujian', [StudentUjianController::class, 'store'])->name('ujian.store');

    // Untuk route yang menggunakan Route Model Binding, kita tambahkan withoutScopedBindings()
    Route::get('/ujian/{ujian}', [StudentUjianController::class, 'show'])->name('ujian.show')->withoutScopedBindings();
    Route::get('/ujian/{ujian}/edit', [StudentUjianController::class, 'edit'])->name('ujian.edit')->withoutScopedBindings();
    Route::put('/ujian/{ujian}', [StudentUjianController::class, 'update'])->name('ujian.update')->withoutScopedBindings();
    Route::delete('/ujian/{ujian}', [StudentUjianController::class, 'destroy'])->name('ujian.destroy')->withoutScopedBindings();

    // Route kustom untuk menandai ujian selesai juga perlu disempurnakan
    Route::patch('/ujian/{ujian}/selesai', [StudentUjianController::class, 'tandaiSelesai'])->name('ujian.selesai')->withoutScopedBindings();
    // --- AKHIR BLOK PERBAIKAN ---

    // Route untuk halaman-halaman lainnya
    Route::get('/materi', [MateriPelajaranController::class, 'index'])->name('materi.index');
    Route::get('/tips-belajar', [TipsBelajarController::class, 'index'])->name('tips.index');
    Route::get('/kalender', [KalenderController::class, 'index'])->name('kalender.index');
});

// Route Autentikasi
require __DIR__ . '/auth.php';
