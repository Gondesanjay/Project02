<?php

namespace App\Filament\Widgets;

use App\Models\Ujian;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB; // Import DB Facade
use Carbon\Carbon; // Import Carbon

class UjianPerBulanChart extends ChartWidget
{
    protected static ?string $heading = 'Jumlah Ujian per Bulan';

    
    protected static ?int $sort = 2;

    protected function getData(): array
    {
        // 1. Ambil data ujian dan kelompokkan berdasarkan bulan
        $data = Ujian::select(
            DB::raw('COUNT(id) as count'),
            DB::raw('MONTH(tanggal_ujian) as month')
        )
            ->whereYear('tanggal_ujian', date('Y')) // Hanya ambil data untuk tahun ini
            ->groupBy('month')
            ->pluck('count', 'month') // Hasilnya: [1=>5, 2=>3, 5=>10] (5 ujian di bulan 1, dst)
            ->all();

        // 2. Siapkan array 12 bulan dengan nilai awal 0
        $monthlyCounts = array_fill(1, 12, 0);

        // 3. Isi array bulan dengan data dari database
        foreach ($data as $month => $count) {
            $monthlyCounts[$month] = $count;
        }

        return [
            // datasets adalah data yang akan digambar di grafik
            'datasets' => [
                [
                    'label' => 'Jumlah Ujian',
                    'data' => array_values($monthlyCounts), // Berikan data 12 bulan
                    'backgroundColor' => 'rgba(54, 162, 235, 0.2)',
                    'borderColor' => 'rgb(54, 162, 235)',
                ],
            ],
            // labels adalah label untuk sumbu-X (Jan, Feb, Mar, ...)
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des'],
        ];
    }

    protected function getType(): string
    {
        // Tentukan tipe chart: 'line', 'bar', 'pie', 'doughnut', dll.
        return 'line';
    }
}
