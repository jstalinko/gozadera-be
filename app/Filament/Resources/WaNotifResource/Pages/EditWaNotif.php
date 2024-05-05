<?php

namespace App\Filament\Resources\WaNotifResource\Pages;

use App\Filament\Resources\WaNotifResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditWaNotif extends EditRecord
{
    protected static string $resource = WaNotifResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
