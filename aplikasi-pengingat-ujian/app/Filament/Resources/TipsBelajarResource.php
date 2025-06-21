<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TipsBelajarResource\Pages;
use App\Filament\Resources\TipsBelajarResource\RelationManagers;
use App\Models\TipsBelajar;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TipsBelajarResource extends Resource
{
    protected static ?string $model = TipsBelajar::class;

    protected static ?string $navigationIcon = 'heroicon-o-light-bulb';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('judul')
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull(),
                
                // Dropdown untuk memilih mata pelajaran, tidak wajib diisi
                Forms\Components\Select::make('mata_pelajaran_id')
                    ->relationship('mataPelajaran', 'nama_mapel')
                    ->searchable()
                    ->preload(),
                
                Forms\Components\RichEditor::make('konten')
                    ->required()
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('judul')
                    ->searchable()
                    ->limit(50),
                Tables\Columns\TextColumn::make('mataPelajaran.nama_mapel')
                    ->label('Terkait Mata Pelajaran')
                    ->badge() // Tampilkan sebagai badge/label
                    ->default('Umum') // Tampilkan 'Umum' jika tidak ada relasi
                    ->sortable(),
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTipsBelajar::route('/'),
            'create' => Pages\CreateTipsBelajar::route('/create'),
            'edit' => Pages\EditTipsBelajar::route('/{record}/edit'),
        ];
    }
}
