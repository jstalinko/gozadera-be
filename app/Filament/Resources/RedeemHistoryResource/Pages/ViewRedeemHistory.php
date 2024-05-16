<?php

namespace App\Filament\Resources\RedeemHistoryResource\Pages;

use App\Filament\Resources\RedeemHistoryResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewRedeemHistory extends ViewRecord
{
    protected static string $resource = RedeemHistoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
