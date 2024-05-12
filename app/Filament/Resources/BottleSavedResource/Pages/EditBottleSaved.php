<?php

namespace App\Filament\Resources\BottleSavedResource\Pages;

use App\Filament\Resources\BottleSavedResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBottleSaved extends EditRecord
{
    protected static string $resource = BottleSavedResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
