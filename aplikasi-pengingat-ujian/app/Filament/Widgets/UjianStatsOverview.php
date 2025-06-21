<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Ujian;

class UjianStatsOverview extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        return [
            Stat::make('Total Ujian', Ujian::count())
                ->description('Semua ujian yang terdaftar')
                ->icon('heroicon-o-calendar'),

            
            Stat::make('Ujian Akan Datang', Ujian::where('is_selesai', false)->count())
                ->description('Ujian yang belum dilaksanakan')
                ->color('success')
                ->icon('heroicon-o-clock'),

            Stat::make('Ujian Telah Selesai', Ujian::where('is_selesai', true)->count())
                ->description('Ujian yang sudah ditandai selesai')
                ->color('warning')
                ->icon('heroicon-o-check-circle'),
        ];
    }
}
