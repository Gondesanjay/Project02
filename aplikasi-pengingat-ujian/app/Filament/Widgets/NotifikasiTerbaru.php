<?php

namespace App\Filament\Widgets;

use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Support\Facades\Auth;
use Illuminate\Notifications\DatabaseNotification;

class NotifikasiTerbaru extends BaseWidget
{
    protected int | string | array $columnSpan = 'full';
    protected static ?string $heading = 'Notifikasi Terbaru';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                // Query langsung ke model DatabaseNotification
                DatabaseNotification::query()
                    ->where('notifiable_type', \App\Models\User::class)
                    ->where('notifiable_id', Auth::id())
                    ->whereNull('read_at')
                    ->latest()
            )
            ->columns([
                // --- PERBAIKAN TYPO DI SINI ---
                Tables\Columns\TextColumn::make('data.pesan')->label('Notifikasi')->wrap(),
                Tables\Columns\TextColumn::make('created_at')->label('Waktu')->since(),
            ])
            ->actions([
                Tables\Actions\Action::make('lihat')
                    ->label('Lihat & Tandai Dibaca')
                    ->url(fn(object $record): string => $record->data['url'] ?? '#')
                    ->openUrlInNewTab()
                    ->after(fn(object $record) => $record->markAsRead()),
            ]);
    }
}
