<?php

namespace App\Filament\Resources\WaNotifResource\Pages;

use App\Filament\Resources\WaNotifResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListWaNotifs extends ListRecords
{
    protected static string $resource = WaNotifResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
