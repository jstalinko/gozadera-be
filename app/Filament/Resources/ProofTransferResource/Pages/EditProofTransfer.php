<?php

namespace App\Filament\Resources\ProofTransferResource\Pages;

use App\Filament\Resources\ProofTransferResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditProofTransfer extends EditRecord
{
    protected static string $resource = ProofTransferResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
