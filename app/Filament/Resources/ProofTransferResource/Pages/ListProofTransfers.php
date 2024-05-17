<?php

namespace App\Filament\Resources\ProofTransferResource\Pages;

use App\Filament\Resources\ProofTransferResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListProofTransfers extends ListRecords
{
    protected static string $resource = ProofTransferResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
