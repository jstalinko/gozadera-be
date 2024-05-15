<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PointSettingResource\Pages;
use App\Filament\Resources\PointSettingResource\RelationManagers;
use App\Models\PointSetting;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PointSettingResource extends Resource
{
    protected static ?string $model = PointSetting::class;

    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';
    protected static ?string $navigationGroup = 'Settings';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('point')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('minimum_spend')
                    ->required()
                    ->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('point')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('minimum_spend')
                    ->numeric()
                    ->sortable(),
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
            'index' => Pages\ListPointSettings::route('/'),
            'create' => Pages\CreatePointSetting::route('/create'),
            'view' => Pages\ViewPointSetting::route('/{record}'),
            'edit' => Pages\EditPointSetting::route('/{record}/edit'),
        ];
    }
}
