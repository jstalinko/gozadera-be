<?php

namespace App\Filament\Resources\OutletTableResource\Pages;

use App\Filament\Resources\OutletTableResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListOutletTables extends ListRecords
{
    protected static string $resource = OutletTableResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
