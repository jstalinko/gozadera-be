<?php

namespace App\Filament\Resources\ProofTransferResource\Pages;

use App\Filament\Resources\ProofTransferResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewProofTransfer extends ViewRecord
{
    protected static string $resource = ProofTransferResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
