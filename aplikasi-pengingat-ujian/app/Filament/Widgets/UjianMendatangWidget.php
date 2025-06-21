<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\UjianResource;
use App\Models\Ujian;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Support\Carbon;
use Filament\Tables\Columns\TextColumn;
use Filament\Support\Enums\FontWeight;

class UjianMendatangWidget extends BaseWidget
{
    protected static ?int $sort = 3; // Pastikan urutannya tetap di bawah chart
    protected int | string | array $columnSpan = 'full';
    protected static ?string $heading = 'Agenda Ujian Terdekat';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Ujian::query()
                    ->where('is_selesai', false)
                    ->orderBy('tanggal_ujian', 'asc')
            )
            ->columns([
                // Kolom Tanggal yang Didesain Ulang
                TextColumn::make('tanggal_ujian')
                    ->label('Tanggal')
                    ->date('l, d F Y') // Format: Minggu, 22 Juni 2025
                    ->weight(FontWeight::Bold)
                    ->description(fn(Ujian $record): string => 'Pukul ' . $record->tanggal_ujian->format('H:i')),

                // Kolom Ujian & Mapel yang Digabung
                TextColumn::make('nama_ujian')
                    ->label('Agenda')
                    ->weight(FontWeight::Medium)
                    ->description(fn(Ujian $record): string => $record->mataPelajaran->nama_mapel),

                // Kolom Waktu Mundur dengan pewarnaan
                TextColumn::make('waktu_mundur')
                    ->label('Waktu Mundur')
                    ->color(fn(Ujian $record): string => match (true) {
                        $record->tanggal_ujian->isToday() => 'danger',
                        $record->tanggal_ujian->isTomorrow() => 'warning',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn(Ujian $record): string => $record->tanggal_ujian->diffForHumans(['parts' => 2])),
            ])
            // Tombol aksi yang lebih simpel
            ->actions([
                Tables\Actions\Action::make('detail')
                    ->label('Lihat Detail')
                    ->url(fn(Ujian $record): string => UjianResource::getUrl('edit', ['record' => $record]))
                    ->icon('heroicon-o-arrow-right-circle'),
            ])
            ->paginated(false); // Menghapus paginasi agar terlihat seperti daftar penuh
    }
}
