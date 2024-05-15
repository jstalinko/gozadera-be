<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BottleSavedResource\Pages;
use App\Filament\Resources\BottleSavedResource\RelationManagers;
use App\Models\BottleSaved;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BottleSavedResource extends Resource
{
    protected static ?string $model = BottleSaved::class;

    protected static ?string $navigationIcon = 'fas-wine-bottle';

    protected static ?string $navigationGroup = 'Products';

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('member_id')
                    ->relationship('member', 'username')
                    ->required()->native(false)->searchable(),
                Forms\Components\Select::make('outlet_id')
                    ->relationship('outlet', 'name')
                    ->required()->native(false),
                Forms\Components\Select::make('product_id')
                    ->relationship('product', 'name')
                    ->required()->native(false)->searchable(),
                Forms\Components\TextInput::make('qty')
                    ->required()
                    ->numeric(),
                Forms\Components\Select::make('status')
                    ->options([
                        'saved' => 'Saved',
                        'expired' => 'Expired',
                        'taken' => 'Taken',
                    ])->default('saved')
                    ->required(),
                Forms\Components\DateTimePicker::make('expired_at')
                    ->required()->default(now()->addDays(7)),
                Forms\Components\Textarea::make('note')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('member.username')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('outlet.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('product.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('qty')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\BadgeColumn::make('status'),
                Tables\Columns\TextColumn::make('expired_at')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('note'),
                Tables\Columns\TextColumn::make('taken_at')
                    ->dateTime()
                    ->sortable()->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('cancelled_at')
                    ->dateTime()
                    ->sortable()->toggleable(isToggledHiddenByDefault: true),
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
            'index' => Pages\ListBottleSaveds::route('/'),
            'create' => Pages\CreateBottleSaved::route('/create'),
            'view' => Pages\ViewBottleSaved::route('/{record}'),
            'edit' => Pages\EditBottleSaved::route('/{record}/edit'),
        ];
    }
}
