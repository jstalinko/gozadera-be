<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RedeemHistoryResource\Pages;
use App\Filament\Resources\RedeemHistoryResource\RelationManagers;
use App\Models\RedeemHistory;
use Filament\Forms;
use Filament\Forms\Form;
use Illuminate\Database\Eloquent\Collection;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class RedeemHistoryResource extends Resource
{
    protected static ?string $model = RedeemHistory::class;

    protected static ?string $navigationIcon = 'fas-sync-alt';

    protected static ?string $navigationGroup = 'Products';

    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('member_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('redeem_point_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('product_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('status')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('member.username')
                    ->sortable(),
                Tables\Columns\TextColumn::make('product.name')
                    ->sortable(),
                Tables\Columns\BadgeColumn::make('status')->color(fn ($record) => match ($record->status) {
                    'approved' => 'success',
                    'rejected' => 'danger',
                    default => 'primary',
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
                // Tables\Actions\ViewAction::make(),
                // Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\BulkAction::make('mark-as-approved')
                        ->action(function (Collection $records) {
                            $records->each->update(['status' => 'approved']);
                        })
                        ->deselectRecordsAfterCompletion()
                        ->color('success')
                        ->icon('heroicon-o-check-circle'),

                    Tables\Actions\BulkAction::make('mark-as-rejected')
                        ->action(function (Collection $records) {
                            $records->each->update(['status' => 'rejected']);
                        })
                        ->deselectRecordsAfterCompletion()
                        ->color('danger')
                        ->icon('heroicon-o-x-circle'),

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
            'index' => Pages\ListRedeemHistories::route('/'),
            'create' => Pages\CreateRedeemHistory::route('/create'),
            'view' => Pages\ViewRedeemHistory::route('/{record}'),
            'edit' => Pages\EditRedeemHistory::route('/{record}/edit'),
        ];
    }
}
