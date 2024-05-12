<?php

namespace App\Filament\Resources\MemberLevelResource\Pages;

use App\Filament\Resources\MemberLevelResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewMemberLevel extends ViewRecord
{
    protected static string $resource = MemberLevelResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
