<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // --- INI ADALAH GABUNGAN DARI KEDUA BLOK ---

        // Menjalankan pengecekan ujian mendatang setiap hari pukul 8 pagi
        // Catatan: Pastikan nama command 'ujian:cek-mendatang' ini sudah benar
        // sesuai dengan file command Anda.
        $schedule->command('ujian:cek-mendatang')->dailyAt('08:00');

        // Menjalankan pembersihan backup lama setiap hari pukul 1 pagi
        $schedule->command('backup:clean')->daily()->at('01:00');

        // Menjalankan backup database setiap hari pukul 2 pagi
        $schedule->command('backup:run --only-db')->daily()->at('02:00');
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
