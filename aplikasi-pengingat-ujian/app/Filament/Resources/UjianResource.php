<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UjianResource\Pages;
use App\Models\Ujian;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification; // Import class Notifikasi
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder; // Import class Builder untuk filter

class UjianResource extends Resource
{
    protected static ?string $model = Ujian::class;
    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('mata_pelajaran_id')
                    ->relationship('mataPelajaran', 'nama_mapel')
                    ->searchable()
                    ->preload()
                    ->required(),
                Forms\Components\TextInput::make('nama_ujian')
                    ->required()
                    ->maxLength(255),
                Forms\Components\DateTimePicker::make('tanggal_ujian')
                    ->required(),
                Forms\Components\RichEditor::make('catatan')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama_ujian')
                    ->searchable(),
                Tables\Columns\TextColumn::make('mataPelajaran.nama_mapel')
                    ->sortable(),
                Tables\Columns\TextColumn::make('tanggal_ujian')
                    ->dateTime('d M Y, H:i') // Format tanggal lebih singkat
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_selesai')
                    ->label('Status')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-badge')
                    ->falseIcon('heroicon-o-clock'),
            ])
            ->filters([
                // Filter berdasarkan status selesai atau belum
                Tables\Filters\TernaryFilter::make('is_selesai')
                    ->label('Status Ujian')
                    ->boolean()
                    ->trueLabel('Selesai')
                    ->falseLabel('Belum Selesai')
                    ->placeholder('Semua'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('tandaiSelesai')
                    ->label('Tandai Selesai')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->requiresConfirmation()
                    // Menyembunyikan tombol jika ujian sudah selesai
                    ->visible(fn(Ujian $record): bool => !$record->is_selesai)
                    ->action(function (Ujian $record) {
                        $record->update(['is_selesai' => true]);
                        // Memberi notifikasi feedback ke pengguna
                        Notification::make()
                            ->title('Ujian berhasil ditandai selesai')
                            ->success()
                            ->send();
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUjians::route('/'),
            'create' => Pages\CreateUjian::route('/create'),
            'edit' => Pages\EditUjian::route('/{record}/edit'),
        ];
    }
}
