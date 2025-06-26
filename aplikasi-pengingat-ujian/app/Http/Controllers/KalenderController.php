<?php

namespace App\Http\Controllers;

use App\Models\Ujian;
use App\Models\Scopes\UserScope;
use Illuminate\Http\Request;
use Illuminate\View\View;

class KalenderController extends Controller
{
    public function index(): View
    {
        // Ambil semua ujian milik user yang login
        $ujians = Ujian::with(['mataPelajaran' => function ($query) {
            $query->withoutGlobalScope(UserScope::class);
        }])
            ->get();

        // Ubah data ujian menjadi format yang dimengerti oleh FullCalendar
        $events = [];
        foreach ($ujians as $ujian) {
            $events[] = [
                'title' => $ujian->nama_ujian . ' (' . optional($ujian->mataPelajaran)->nama_mapel . ')',
                'start' => $ujian->tanggal_ujian->toIso8601String(), // Format tanggal standar
                'end' => $ujian->tanggal_ujian->addHours(2)->toIso8601String(), // Asumsi durasi ujian 2 jam
                'url' => route('ujian.edit', $ujian), // Link jika event di-klik
                'color' => $ujian->is_selesai ? '#6B7280' : '#3B82F6', // Warna berbeda untuk ujian selesai
            ];
        }

        // --- INI BAGIAN YANG DIPERBAIKI ---
        // Kirim data sebagai Array PHP biasa, tanpa json_encode()
        return view('kalender.index', [
            'events' => $events
        ]);
    }
}
