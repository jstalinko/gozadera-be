<?php

namespace App\Filament\Resources\RsvpResource\Pages;

use App\Filament\Resources\RsvpResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRsvp extends EditRecord
{
    protected static string $resource = RsvpResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
    protected function mutateFormDataBeforeSave(array $data): array
    {
        $STATUS = [
            'paid' => 'issued',
            'unpaid' => 'waiting_payment',
            'canceled' => 'canceled',
            'expired' => 'expired'
        ];
        $data['status'] = $STATUS[$data['payment_status']];

        return $data;
    }
}
