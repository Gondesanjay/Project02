<?php

namespace App\Filament\Widgets;

use App\Models\Scopes\UserScope;
use App\Filament\Resources\UjianResource;
use App\Models\Ujian;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Filament\Tables\Columns\TextColumn;

class UjianMendatangWidget extends BaseWidget
{
    protected static ?int $sort = 3;
    protected int | string | array $columnSpan = 'full';
    protected static ?string $heading = 'Agenda Ujian Global Terdekat';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                // Mengambil data ujian global tanpa filter user
                Ujian::withoutGlobalScope(UserScope::class)
                    ->where('is_selesai', false)
                    ->orderBy('tanggal_ujian', 'asc')
            )
            ->columns([
                // --- INI KOLOM-KOLOM BARU ANDA YANG SUDAH DIRAPIKAN ---
                TextColumn::make('user.name')
                    ->label('Mahasiswa')
                    ->searchable(),

                TextColumn::make('nama_ujian')
                    ->label('Agenda')
                    ->description(fn(Ujian $record): string => $record->mataPelajaran->nama_mapel ?? 'N/A'),

                TextColumn::make('tanggal_ujian')
                    ->label('Tanggal')
                    ->date('l, d F Y')
                    ->description(fn(Ujian $record): string => 'Pukul ' . $record->tanggal_ujian->format('H:i')),

                TextColumn::make('lokasi')
                    ->label('Lokasi/Ruang')
                    ->default('Belum diatur')
                    ->badge()
                    ->color('warning'),
            ])
            ->actions([
                Tables\Actions\Action::make('detail')
                    ->label('Lihat Detail')
                    ->url(fn(Ujian $record): string => UjianResource::getUrl('edit', ['record' => $record]))
                    ->icon('heroicon-o-arrow-right-circle'),
            ])
            ->paginated(false);
    }
}
