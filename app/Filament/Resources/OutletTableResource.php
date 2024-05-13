<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\OutletTable;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\OutletTableResource\Pages;
use App\Filament\Resources\OutletTableResource\RelationManagers;
use Filament\Forms\Components\FileUpload;

class OutletTableResource extends Resource
{
    protected static ?string $model = OutletTable::class;

    protected static ?string $navigationIcon = 'heroicon-o-queue-list';
    protected static ?string $navigationGroup = 'Outlet & Tables';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('outlet_id')->relationship('outlet','name')->required()->native(false),
                TextInput::make('code')->label('Table No.')->required(),
                Select::make('floor')->options([
                    1 => '1',
                    2 => '2',
                    3 => '3',
                    4 => '4',
                    5 => '5',
                    6 => '6',
                    7 => '7',
                    8 => '8',
                    9 => '9',
                    10 => '10',
                ])->required()->native(false),
                Select::make('max_pax')->options([
                    2 => '2',
                    3 => '3',
                    4 => '4',
                    5 => '5',
                    6 => '6',
                    7 => '7',
                    8 => '8',
                    9 => '9',
                    10 => '10',
                    11 => '11',
                    12 => '12',
                ])->required()->native(false),
                TextInput::make('price')->required(),
                FileUpload::make('image')->required()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
             Tables\Columns\TextColumn::make('outlet.name')->label('Outlet'),
             Tables\Columns\ImageColumn::make('image')->label('Image')->toggleable(isToggledHiddenByDefault:    true),
             Tables\Columns\ImageColumn::make('qrcode')->toggleable(isToggledHiddenByDefault: true),
             Tables\Columns\TextColumn::make('floor')->label('LT')->description('Lantai'),
             Tables\Columns\TextColumn::make('max_pax')->label('Max Pax')->description(' Person')->sortable(),
             Tables\Columns\TextColumn::make('code')->label('Table No.'),
             Tables\Columns\TextColumn::make('price')->label('Price')->money('idr'),
             Tables\Columns\BadgeColumn::make('status')->label('Status')->color(fn (string $state): string => match ($state) {
                'available' => 'success',
                'booked' => 'danger',
                'on_hold' => 'grey',
            })
             ->sortable()
                
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
            ])
            ->searchable();
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
            'index' => Pages\ListOutletTables::route('/'),
            'create' => Pages\CreateOutletTable::route('/create'),
            'view' => Pages\ViewOutletTable::route('/{record}'),
            'edit' => Pages\EditOutletTable::route('/{record}/edit'),
        ];
    }
}
