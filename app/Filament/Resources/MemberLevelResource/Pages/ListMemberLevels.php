<?php

namespace App\Filament\Resources\MemberLevelResource\Pages;

use App\Filament\Resources\MemberLevelResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMemberLevels extends ListRecords
{
    protected static string $resource = MemberLevelResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
