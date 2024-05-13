<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\Rsvp;
use Filament\Tables;
use Filament\Forms\Get;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\RsvpResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\RsvpResource\RelationManagers;
use App\Models\OutletTable;
use Filament\Forms\Set;

class RsvpResource extends Resource
{
    protected static ?string $model = Rsvp::class;

    protected static ?string $navigationIcon = 'heroicon-o-envelope';

    protected static ?string $navigationGroup = 'Rsvp & Item orders';
    
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('member_id')
                    ->relationship('member' , 'username')
                    ->searchable()
                    ->native(false)
                    ->required(),
                Forms\Components\Select::make('outlet_id')
                    ->relationship('outlet' , 'name')
                    ->native(false)
                    ->required()
                    ->live(onBlur: true),
                Forms\Components\Select::make('table_id')
                    ->relationship('outlet_tables' , 'code' , function (Builder $query , Get $get) {
                        $query->where('outlet_id', $get('outlet_id'));
                        $query->where('status', 'available');
                    })
                    ->native(false)
                    ->visible(fn (Get $get) => filled($get('outlet_id')))
                    ->getOptionLabelFromRecordUsing(fn ($record) => $record->floor . ' Floor - Table No:' .$record->code . ' - Max Pax:'. $record->max_pax)
                    ->live(onBlur: true)
                    ->afterStateUpdated(function (Set $set,$state) {
                        $set('pax', OutletTable::find($state)->max_pax);
                        $set('table_price', number_format(OutletTable::find($state)->price));
                        $set('subtotal', number_format(OutletTable::find($state)->price));

                    }),
                    
                    Forms\Components\TextInput::make('pax')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('table_price')
                    ->required()
                    ->disabled()->prefix('IDR'),
                Forms\Components\TextInput::make('subtotal')
                    ->required()
                    ->disabled()->prefix('IDR'),
                Forms\Components\Select::make('payment_status')
                    ->options([
                        'unpaid' => 'Unpaid',
                        'paid' => 'Paid',
                    ])
                    ->required()->native(false),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('member.username')
                    ->sortable(),
                Tables\Columns\TextColumn::make('outlet.name')
                    ->sortable(),
                Tables\Columns\TextColumn::make('pax')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('table_id')
                    ->getStateUsing(function (Rsvp $record) {
                        return $record->outlet_tables->floor . ' Floor - Table No:' . $record->outlet_tables->code ;
                    })
                    ->sortable(),
                Tables\Columns\TextColumn::make('table_price')
                    ->numeric()
                    ->sortable()->money('idr'),
                Tables\Columns\TextColumn::make('subtotal')
                    ->numeric()
                    ->sortable()->money('idr'),
                Tables\Columns\BadgeColumn::make('payment_status')->color(fn (string $state): string => match ($state) {
                    'unpaid' => 'danger',
                    'paid' => 'success',
                    'expired' => 'grey',
                    'cancelled' => 'grey',
                })
                    ->sortable(),
                Tables\Columns\BadgeColumn::make('status')->color(fn (string $state): string => match ($state) {
                    'check_in' => 'success',
                    'check_out' => 'danger',
                    'cancelled' => 'grey',
                    'expired' => 'grey',
                    'issued' => 'primary',
                })
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
            ])->searchable();
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
            'index' => Pages\ListRsvps::route('/'),
            'create' => Pages\CreateRsvp::route('/create'),
            'view' => Pages\ViewRsvp::route('/{record}'),
            'edit' => Pages\EditRsvp::route('/{record}/edit'),
        ];
    }
}
