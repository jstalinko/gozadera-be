<?php

namespace App\Filament\Resources\MemberLevelResource\Pages;

use App\Filament\Resources\MemberLevelResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMemberLevel extends EditRecord
{
    protected static string $resource = MemberLevelResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
