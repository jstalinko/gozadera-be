<?php

namespace App\Filament\Pages;

use Filament\Forms\Form;
use Filament\Pages\Page;
use App\Models\WaNotif;
use Closure;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;

class WaNotifTest extends Page
{
    protected static ?string $navigationIcon = 'heroicon-m-arrow-right';

    protected static string $view = 'filament.pages.wa-notif-test';

    protected static string $label = 'WA Notif Test';

    protected static ?string $navigationGroup = 'Settings';
    protected static ?int $navigationSort = 3;

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('phone')
                    ->label('Phone Number')
                    ->placeholder('6281234567890')
                    ->required()->live()->afterStateUpdated(
                        fn(Closure $state , callable $set) => $set('phone','62'.ltrim($state['phone'],'0'))
                    ),
                Select::make('type')
                    ->label('Type')
                    ->options(WaNotif::all()->pluck('type', 'message'))
                    ->required()->native(false)->reactive()->afterStateUpdated(
                        fn(Closure $state , callable $set) => $set('message',$state['type'])
                    ),
                Textarea::make('message')
                    ->label('Message')
                    ->placeholder('Your message here...')
                    ->required(),
            ]);
    }
}
