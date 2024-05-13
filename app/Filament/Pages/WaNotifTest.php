<?php

namespace App\Filament\Pages;

use App\Helper\Helper;
use App\Models\WaNotif;
use Filament\Forms\Set;
use Filament\Forms\Form;
use Filament\Pages\Page;
use Filament\Facades\Filament;
use Filament\Pages\Actions\Action;
use Illuminate\Support\Facades\Bus;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Actions;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Forms\Concerns\InteractsWithForms;

class WaNotifTest extends Page implements HasForms
{
    use InteractsWithForms;
    protected static ?string $navigationIcon = 'heroicon-m-arrow-right';

    protected static string $view = 'filament.pages.wa-notif-test';

    protected static string $label = 'WA Notif Test';

    protected static ?string $navigationGroup = 'Settings';
    protected static ?int $navigationSort = 3;

    public $phone;
    public $type;
    public $message;
    public function form(Form $form): Form
    {


        return $form
            ->schema([
                TextInput::make('phone')
                    ->label('Phone Number')
                    ->placeholder('6281234567890')
                    ->required()
                    ->live(onBlur: true)
                    ->afterStateUpdated(function (Set $set, $state) {
                        $set('phone', preg_replace('/[^0-9]/', '', $state));
                        $set('phone', substr($state, 0, 1) == '0' ? '62' . substr($state, 1) : $state);
                    }),
                Select::make('type')
                    ->options(WaNotif::select('type')->distinct()->get()->pluck('type', 'type'))
                    ->required()
                    ->native(false)
                    ->live(onBlur: true)
                    ->afterStateUpdated(function (Set $set, $state) {
                        $set('message', WaNotif::where('type', $state)->first()->message);
                    }),
                Textarea::make('message')
                    ->label('Message')
                    ->required(),
                    \Filament\Forms\Components\Actions::make([
                        \Filament\Forms\Components\Actions\Action::make('Send Whatsapp')
                            ->action('submit')
                    ])->fullWidth()
                ]);
    }



    public function submit()
    {
        $response = Helper::sendWhatsappMessage($this->phone, $this->message);
    
        Notification::make() 
        ->title(
            'Message Sent Successfully'
        )
        ->danger()
        ->send(); 
       
    }
}
