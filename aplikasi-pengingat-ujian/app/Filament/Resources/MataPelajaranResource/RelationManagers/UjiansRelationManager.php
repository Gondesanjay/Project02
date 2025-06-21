<?php

namespace App\Filament\Resources\MataPelajaranResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UjiansRelationManager extends RelationManager
{
    protected static string $relationship = 'ujians';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nama_ujian')
                    ->required()
                    ->maxLength(255),
                Forms\Components\DateTimePicker::make('tanggal_ujian')
                    ->required(),
                Forms\Components\RichEditor::make('catatan')
                    ->columnSpanFull(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('nama_ujian')
            ->columns([
                Tables\Columns\TextColumn::make('nama_ujian'),
                Tables\Columns\TextColumn::make('tanggal_ujian')
                    ->dateTime('d F Y')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
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
}
