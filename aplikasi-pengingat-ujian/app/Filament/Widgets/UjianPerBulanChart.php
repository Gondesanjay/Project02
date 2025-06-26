<?php

namespace App\Filament\Widgets;

use App\Models\Scopes\UserScope;
use App\Models\Ujian;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;

class UjianPerBulanChart extends ChartWidget
{
    protected static ?string $heading = 'Jumlah Ujian per Bulan (Global)';
    protected static ?int $sort = 2; // Tampil setelah statistik

    protected function getData(): array
    {
        // Ambil semua data ujian tanpa filter user
        $data = Ujian::withoutGlobalScope(UserScope::class)
            ->select('created_at')
            ->get()
            ->groupBy(function($date) {
                // Kelompokkan berdasarkan bulan
                return Carbon::parse($date->created_at)->format('M'); // M = Jan, Feb, Mar, etc.
            });
        
        $labels = [];
        $values = [];
        $months = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];

        foreach ($months as $month) {
            $labels[] = $month;
            // Jika ada data untuk bulan tersebut, hitung jumlahnya. Jika tidak, nilainya 0.
            $values[] = $data->has($month) ? $data[$month]->count() : 0;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Jumlah Ujian',
                    'data' => $values,
                    'backgroundColor' => '#36A2EB',
                    'borderColor' => '#36A2EB',
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line'; // Tipe grafik adalah garis (line chart)
    }
}
