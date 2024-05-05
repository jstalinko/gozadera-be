<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\WaNotif;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\WaNotifResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\WaNotifResource\RelationManagers;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;

class WaNotifResource extends Resource
{
    protected static ?string $model = WaNotif::class;

    protected static ?string $navigationIcon = 'heroicon-s-phone';
    
    protected static ?string $modelLabel = 'WA Notification';

    protected static ?string $navigationGroup = 'Settings';
    
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('type')->native(false)->options([
                    'order' => 'Order',
                    'payment' => 'Payment',
                    'register' => 'Register',
                    'reset_password' => 'Reset Password',
                    'welcome' => 'Welcome',
                    'custom' => 'Custom',
                    'promo' => 'Promo',
                    'other' => 'Other',
                ])->required(),
                Textarea::make('message')->required()->helperText('Use {name} for user name, {order_id} for order id, {payment_id} for payment id, {reset_code} for reset code, {promo_code} for promo code, {promo_name} for promo name, {promo_value} for promo value, {promo_period} for promo period, {promo_start} for promo start date, {promo_end} for promo end date, {register_code} for register code, {register_link} for register link, {other} for other message'),
                Toggle::make('active')->default(true),

            ])->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('type')->label('Type'),
                Tables\Columns\TextColumn::make('message')->label('Message'),
                Tables\Columns\BooleanColumn::make('active')->label('Active'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListWaNotifs::route('/'),
            'create' => Pages\CreateWaNotif::route('/create'),
            'view' => Pages\ViewWaNotif::route('/{record}'),
            'edit' => Pages\EditWaNotif::route('/{record}/edit'),
        ];
    }
}
