<?php

namespace App\Filament\Resources\RedeemHistoryResource\Pages;

use App\Filament\Resources\RedeemHistoryResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRedeemHistory extends EditRecord
{
    protected static string $resource = RedeemHistoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
