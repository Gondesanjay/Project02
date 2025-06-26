<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UjianResource\Pages;
use App\Models\Ujian;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class UjianResource extends Resource
{
    protected static ?string $model = Ujian::class;
    protected static ?string $navigationIcon = 'heroicon-o-pencil-square';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Hidden::make('user_id')
                    ->default(auth()->id()),

                Forms\Components\Select::make('mata_pelajaran_id')
                    ->relationship('mataPelajaran', 'nama_mapel')
                    ->searchable()
                    ->preload()
                    ->required(),

                Forms\Components\TextInput::make('nama_ujian')
                    ->required()
                    ->maxLength(255),

                // --- INPUT BARU UNTUK LOKASI ---
                Forms\Components\TextInput::make('lokasi')
                    ->label('Lokasi / Ruang Ujian')
                    ->placeholder('Contoh: R.401, Gedung A')
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
                Tables\Columns\TextColumn::make('nama_ujian')->searchable(),
                Tables\Columns\TextColumn::make('mataPelajaran.nama_mapel')->sortable(),
                Tables\Columns\TextColumn::make('lokasi')->searchable()->sortable(), // <-- Tampilkan lokasi di tabel
                Tables\Columns\TextColumn::make('tanggal_ujian')->dateTime()->sortable(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ]);
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
