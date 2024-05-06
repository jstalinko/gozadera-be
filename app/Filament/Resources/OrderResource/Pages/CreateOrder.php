<?php

namespace App\Filament\Resources\OrderResource\Pages;

use App\Filament\Resources\OrderResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateOrder extends CreateRecord
{
    protected static string $resource = OrderResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
            $subtotal = 0;
        foreach($data['items'] as $it)
        {
            $xx = explode("|",$it);
            $item_name = $xx[0];
            $item_price = $xx[1];

            $item_price+=$item_price;
        }
        $subtotal = $subtotal+($item_price);
        $data['subtotal'] = $subtotal;
        $data['items'] = json_encode($data['items']);

    

        return $data;
    }
}
