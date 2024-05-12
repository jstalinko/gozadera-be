<?php

namespace App\Filament\Resources\RedeemPointResource\Pages;

use App\Filament\Resources\RedeemPointResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewRedeemPoint extends ViewRecord
{
    protected static string $resource = RedeemPointResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
