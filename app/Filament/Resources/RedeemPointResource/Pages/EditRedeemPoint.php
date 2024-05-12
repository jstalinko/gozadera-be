<?php

namespace App\Filament\Resources\RedeemPointResource\Pages;

use App\Filament\Resources\RedeemPointResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRedeemPoint extends EditRecord
{
    protected static string $resource = RedeemPointResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
