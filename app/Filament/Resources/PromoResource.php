<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Promo;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\PromoResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\PromoResource\RelationManagers;

class PromoResource extends Resource
{
    protected static ?string $model = Promo::class;

    protected static ?string $navigationIcon = 'heroicon-s-ticket';
    protected static ?string $navigationGroup = 'Products';
    protected static ?string $modelLabel = 'Promo & Event';
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')->required(),
                TextInput::make('description')->required(),
                Select::make('discount_type')->options(['percent','nominal'])->required()->native(false),
                TextInput::make('discount_value')->required(),
                Select::make('promo_period')->options(['allday','weekday','weekend','date'])->required()->native(false),
                DatePicker::make('promo_start')->required()->format('d-m-Y'),
                DatePicker::make('promo_end')->required()->format('d-m-Y'),
                FileUpload::make('image')->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label('Name'),
                TextColumn::make('discount_type')->label('Discount')->description(function (Promo $promo) {
                    if($promo->discount_type == 'percent')
                    {
                        return $promo->discount_value.' %';
                    }else{
                        return 'IDR '.$promo->discount_value;
                    }
                }),
                TextColumn::make('promo_period')->label('Promo Period'),
                TextColumn::make('promo_start')->label('Start Date'),
                TextColumn::make('promo_end')->label('End Date'),
                TextColumn::make('status')->label('Status'),
                Tables\Columns\ImageColumn::make('image')->label('Image'),

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
            'index' => Pages\ListPromos::route('/'),
            'create' => Pages\CreatePromo::route('/create'),
            'view' => Pages\ViewPromo::route('/{record}'),
            'edit' => Pages\EditPromo::route('/{record}/edit'),
        ];
    }
}
