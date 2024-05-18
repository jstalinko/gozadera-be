<?php

namespace App\Filament\Resources\RsvpResource\Pages;

use App\Filament\Resources\RsvpResource;
use Filament\Resources\Pages\Page;

class ScanQR extends Page
{
    protected static string $resource = RsvpResource::class;

    protected static string $view = 'filament.resources.rsvp-resource.pages.scan-q-r';
}
