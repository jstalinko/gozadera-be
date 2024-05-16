<?php

namespace App\Filament\Resources\RedeemHistoryResource\Pages;

use App\Filament\Resources\RedeemHistoryResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListRedeemHistories extends ListRecords
{
    protected static string $resource = RedeemHistoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
