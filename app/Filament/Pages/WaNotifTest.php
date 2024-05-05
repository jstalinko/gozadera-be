<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class WaNotifTest extends Page
{
    protected static ?string $navigationIcon = 'heroicon-m-arrow-right';

    protected static string $view = 'filament.pages.wa-notif-test';

    protected static string $label = 'WA Notif Test';

    protected static ?string $navigationGroup = 'Settings';
    protected static ?int $navigationSort = 3;

    
}
