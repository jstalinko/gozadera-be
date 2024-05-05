<?php

namespace App\Filament\Resources\OutletTableResource\Pages;

use App\Filament\Resources\OutletTableResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditOutletTable extends EditRecord
{
    protected static string $resource = OutletTableResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
