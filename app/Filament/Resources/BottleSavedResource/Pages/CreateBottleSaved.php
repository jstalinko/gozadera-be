<?php

namespace App\Filament\Resources\BottleSavedResource\Pages;

use App\Filament\Resources\BottleSavedResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateBottleSaved extends CreateRecord
{
    protected static string $resource = BottleSavedResource::class;

    // protected function mutateFormDataBeforeCreate(array $data): array
    // {
    //       $products = $data;

    //       dd($products);
    // }
}
