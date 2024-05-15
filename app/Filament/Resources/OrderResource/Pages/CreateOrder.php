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
        $jsonItems = [];
        foreach($data['items'] as $it)
        {
            $xx = explode("|",$it);
            $item_id = $xx[0];
            $item_name = $xx[1];
            $item_price = $xx[2];
            $item_qty = 1;
            $jsonItems[] = [
                'id' => $item_id,
                'name' => $item_name,
                'price' => $item_price,
                'qty' => $item_qty
            ];
            $item_price+=$item_price;
        }
        $subtotal = $subtotal+($item_price);
        $data['subtotal'] = $subtotal;
        $data['items'] = json_encode($jsonItems);

    

        return $data;
    }
}
