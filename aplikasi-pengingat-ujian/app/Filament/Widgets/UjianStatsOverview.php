<?php

namespace App\Filament\Widgets;

use App\Models\Scopes\UserScope;
use App\Models\Ujian;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class UjianStatsOverview extends BaseWidget
{
    protected static ?int $sort = 1; // Tampil paling atas

    protected function getStats(): array
    {
        return [
            Stat::make('Total Ujian', Ujian::withoutGlobalScope(UserScope::class)->count())
                ->description('Semua ujian yang terdaftar dari semua pengguna')
                ->icon('heroicon-o-calendar-days')
                ->color('primary'),

            Stat::make('Ujian Akan Datang', Ujian::withoutGlobalScope(UserScope::class)->where('is_selesai', false)->count())
                ->description('Ujian yang belum dilaksanakan dari semua pengguna')
                ->icon('heroicon-o-clock')
                ->color('success'),

            Stat::make('Ujian Telah Selesai', Ujian::withoutGlobalScope(UserScope::class)->where('is_selesai', true)->count())
                ->description('Ujian yang sudah ditandai selesai oleh pengguna')
                ->icon('heroicon-o-check-circle')
                ->color('warning'),
        ];
    }
}
