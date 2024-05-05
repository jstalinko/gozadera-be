<?php

namespace App\Filament\Resources\WaNotifResource\Pages;

use App\Filament\Resources\WaNotifResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewWaNotif extends ViewRecord
{
    protected static string $resource = WaNotifResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
