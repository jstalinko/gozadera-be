<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Banner;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\BannerResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\BannerResource\RelationManagers;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Columns\BadgeColumn;

class BannerResource extends Resource
{
    protected static ?string $model = Banner::class;

    protected static ?string $navigationIcon = 'heroicon-s-photo';

    protected static ?string $navigationGroup = 'Settings';
    

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title')->required()->minLength(4),
                TextInput::make('description')->required()->minLength(10),
                TextInput::make('link')->default('#'),
                FileUpload::make('image')->required(),
                Toggle::make('active')->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image')->label('Image'),
                TextColumn::make('title'),
                TextColumn::make('description')
                ->limit(50)
                ->tooltip(
                    fn (Banner $record) => $record->description
                )->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('link')->copyable()->toggleable(isToggledHiddenByDefault: true),
                BadgeColumn::make('status')->color(fn (string $state): string => match ($state) {
                    'inactive' => 'gray',
                    'active' => 'success',
                })

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
            'index' => Pages\ListBanners::route('/'),
            'create' => Pages\CreateBanner::route('/create'),
            'view' => Pages\ViewBanner::route('/{record}'),
            'edit' => Pages\EditBanner::route('/{record}/edit'),
        ];
    }
}
