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
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Storage;

class MataPelajaranResource extends Resource
{
    protected static ?string $model = MataPelajaran::class;
    protected static ?string $navigationIcon = 'heroicon-o-book-open';

    // Metode mutateFormDataBeforeCreate sudah kita hapus

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // --- INI ADALAH PERBAIKAN UTAMA ---
                // Menambahkan input tersembunyi yang nilainya adalah ID user yang login
                Forms\Components\Hidden::make('user_id')
                    ->default(auth()->id()),

                // Sisa form Anda seperti biasa
                Forms\Components\TextInput::make('nama_mapel')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('nama_dosen')
                    ->maxLength(255),
                Forms\Components\FileUpload::make('materi_path')
                    ->label('File Materi')
                    ->directory('materi-pelajaran')
                    ->acceptedFileTypes(['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'])
                    ->columnSpanFull(),
            ]);
    }

    // ... sisa kode table(), getRelations(), getPages() Anda biarkan sama ...
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama_mapel')->searchable(),
                Tables\Columns\TextColumn::make('nama_dosen')->searchable(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('download')
                    ->label('Download Materi')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->color('info')
                    ->url(fn($record) => $record->materi_path ? Storage::url($record->materi_path) : null, shouldOpenInNewTab: true)
                    ->visible(fn($record): bool => $record->materi_path !== null),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListMataPelajaran::route('/'),
            'create' => Pages\CreateMataPelajaran::route('/create'),
            'edit' => Pages\EditMataPelajaran::route('/{record}/edit'),
        ];
    }
}
