<?php

namespace App\Console\Commands;

use App\Models\Ujian;
use App\Mail\UjianReminderMail;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class UjianCekMendatang extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ujian:cek-mendatang';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Mengecek jadwal ujian yang akan datang (H-7, H-3, H-1) dan mengirim email pengingat.';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $this->info('Mulai proses pengecekan jadwal ujian...');

        $reminderDays = [7, 3, 1];

        foreach ($reminderDays as $day) {
            $targetDate = Carbon::today()->addDays($day)->toDateString();
            $this->line("Mencari ujian untuk H-{$day} pada tanggal: {$targetDate}");

            // 1. Menggunakan chunk() untuk efisiensi memori jika data sangat banyak
            Ujian::with('user')
                ->whereDate('tanggal_ujian', $targetDate)
                ->where('is_selesai', false)
                ->chunk(100, function (Collection $ujians) {
                    $this->info("-> Ditemukan {$ujians->count()} ujian. Memulai pengiriman email...");

                    foreach ($ujians as $ujian) {
                        if ($ujian->user && $ujian->user->email) {
                            // 2. Menggunakan try-catch untuk keamanan
                            try {
                                Mail::to($ujian->user)->send(new UjianReminderMail($ujian));
                                $this->info("   - Email pengingat untuk '{$ujian->nama_ujian}' telah dikirim ke {$ujian->user->email}.");
                            } catch (\Exception $e) {
                                $this->error("   - Gagal mengirim email untuk ujian ID: {$ujian->id}. Error: " . $e->getMessage());
                            }
                        }
                    }
                });
        }

        $this->info('Proses pengecekan selesai.');
    }
}
