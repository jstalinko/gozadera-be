<?php

namespace App\Filament\Resources\RsvpResource\Pages;

use App\Filament\Resources\RsvpResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateRsvp extends CreateRecord
{
    protected static string $resource = RsvpResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $outletTable = \App\Models\OutletTable::find($data['table_id']);
        $data['subtotal'] = $outletTable->price;
        $data['table_price'] = $outletTable->price;
        $data['items'] = json_encode([]);
        if($data['payment_status'] == 'paid')
        {
            // update outlet table to booked
            $outletTable->status = 'booked';
        }elseif($data['payment_status'] == 'unpaid')
        {
            // update outlet table to available
            $outletTable->status = 'on_hold';
        }else{
            // update outlet table to available
            $outletTable->status = 'available';
        }
        $outletTable->save();
        return $data;
    }
}
