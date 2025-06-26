<?php

namespace App\Filament\Resources\TipsBelajarResource\Pages;

use App\Filament\Resources\TipsBelajarResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTipsBelajar extends ListRecords
{
    protected static string $resource = TipsBelajarResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
