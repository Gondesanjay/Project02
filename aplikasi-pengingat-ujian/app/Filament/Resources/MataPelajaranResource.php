<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MataPelajaranResource\Pages;
use App\Filament\Resources\MataPelajaranResource\RelationManagers;
use App\Models\MataPelajaran;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Storage;

class MataPelajaranResource extends Resource
{
    protected static ?string $model = MataPelajaran::class;

    protected static ?string $navigationIcon = 'heroicon-o-book-open';
    

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nama_mapel')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('nama_dosen')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\FileUpload::make('materi_path')
                ->label('File Materi')
                ->directory('materi-pelajaran') // File akan disimpan di storage/app/public/materi-pelajaran
                ->acceptedFileTypes(['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document']) // Hanya izinkan PDF & Word
                ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama_mapel')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nama_dosen')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),

                Tables\Actions\Action::make('download')
                ->label('Download Materi')
                ->icon('heroicon-o-arrow-down-tray')
                ->color('info')
                // Tentukan URL untuk download
                ->url(fn ($record) => Storage::url($record->materi_path), shouldOpenInNewTab: true)
                // Hanya tampilkan tombol jika file materi ada
                ->visible(fn ($record): bool => $record->materi_path !== null),

            Tables\Actions\DeleteAction::make(),
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
            // Daftarkan di sini
            RelationManagers\UjiansRelationManager::class,
            RelationManagers\TipsBelajarRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMataPelajarans::route('/'),
            'create' => Pages\CreateMataPelajaran::route('/create'),
            'edit' => Pages\EditMataPelajaran::route('/{record}/edit'),
        ];
    }
}
