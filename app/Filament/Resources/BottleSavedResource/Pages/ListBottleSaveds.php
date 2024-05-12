<?php

namespace App\Filament\Resources\BottleSavedResource\Pages;

use App\Filament\Resources\BottleSavedResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBottleSaveds extends ListRecords
{
    protected static string $resource = BottleSavedResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
