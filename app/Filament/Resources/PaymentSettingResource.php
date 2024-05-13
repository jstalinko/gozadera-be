<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Get;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\PaymentSetting;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\PaymentSettingResource\Pages;
use App\Filament\Resources\PaymentSettingResource\RelationManagers;

class PaymentSettingResource extends Resource
{
    protected static ?string $model = PaymentSetting::class;

    protected static ?string $navigationIcon = 'far-money-bill-alt';

    protected static ?string $navigationGroup = 'Settings';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('type')
                    ->required()
                    ->options([
                        'transfer' => 'Transfer Bank',
                        'qris' => 'QRIS',
                    ])
                    ->native(false)
                    ->live(onBlur: true)
                    ,
                Forms\Components\TextInput::make('account_number')
                    ->maxLength(255)
                    ->default(null)->visible(fn (Get $get) => $get('type') === 'transfer'),
                Forms\Components\TextInput::make('account_name')
                    ->maxLength(255)
                    ->default(null)->visible(fn (Get $get) => filled($get('type'))),
                Forms\Components\TextInput::make('bank_name')
                    ->maxLength(255)
                    ->default(null)->visible(fn (Get $get) => $get('type') === 'transfer'),
                Forms\Components\FileUpload::make('qris_image')
                    ->image()->visible(fn (Get $get) => $get('type') === 'qris'),
                Forms\Components\Toggle::make('status')
                    ->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('type'),
                Tables\Columns\TextColumn::make('account_number')
                    ->searchable(),
                Tables\Columns\TextColumn::make('account_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('bank_name')
                    ->searchable(),
                Tables\Columns\ImageColumn::make('qris_image'),
                Tables\Columns\BadgeColumn::make('status')->color(fn (string $state): string => match ($state) {
                    'inactive' => 'gray',
                    'active' => 'success',
                }),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
            'index' => Pages\ListPaymentSettings::route('/'),
            'create' => Pages\CreatePaymentSetting::route('/create'),
            'view' => Pages\ViewPaymentSetting::route('/{record}'),
            'edit' => Pages\EditPaymentSetting::route('/{record}/edit'),
        ];
    }
}
