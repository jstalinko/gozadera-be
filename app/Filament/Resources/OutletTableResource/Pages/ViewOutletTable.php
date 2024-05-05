<?php

namespace App\Filament\Resources\OutletTableResource\Pages;

use App\Filament\Resources\OutletTableResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewOutletTable extends ViewRecord
{
    protected static string $resource = OutletTableResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
