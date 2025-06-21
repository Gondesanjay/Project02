<?php

namespace App\Console\Commands;

use App\Models\Ujian;
use App\Models\User;
use App\Notifications\PengingatUjianNotification;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CekUjianMendatang extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:cek-ujian-mendatang';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Mengecek jadwal ujian yang akan datang dan mengirim notifikasi ke semua channel.';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('Mulai mengecek jadwal ujian mendatang...');

        $users = User::all();
        if ($users->isEmpty()) {
            $this->warn('Tidak ada user ditemukan untuk dikirimi notifikasi.');
            return Command::SUCCESS;
        }

        $reminderDays = [7, 3, 1];

        foreach ($reminderDays as $day) {
            $targetDate = Carbon::today()->addDays($day)->toDateString();

            // Menggunakan Eager Loading (with) agar lebih efisien
            $ujians = Ujian::with('mataPelajaran')->whereDate('tanggal_ujian', $targetDate)->get();

            if ($ujians->isEmpty()) {
                $this->line("Tidak ada ujian untuk H-{$day}.");
                continue; // Lanjut ke iterasi hari berikutnya
            }

            foreach ($ujians as $ujian) {
                // Pengecekan keamanan untuk memastikan relasi ada
                if (!$ujian->mataPelajaran) {
                    $this->warn("Ujian '{$ujian->nama_ujian}' tidak memiliki Mata Pelajaran. Notifikasi dilewati.");
                    continue;
                }

                $this->info("Ujian ditemukan: '{$ujian->nama_ujian}'. Mengirim notifikasi...");

                // --- BAGIAN PENTING ---
                // Mengirim notifikasi ke setiap user menggunakan class Notifikasi kita.
                // Cara ini akan memicu semua channel (database & mail).
                foreach ($users as $user) {
                    $user->notify(new PengingatUjianNotification($ujian));
                }
            }
        }

        $this->info('Pengecekan selesai.');
        return Command::SUCCESS;
    }
}
