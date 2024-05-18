<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\Rsvp;
use Filament\Tables;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\OutletTable;
use Filament\Resources\Resource;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use App\Filament\Resources\RsvpResource\Pages;


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
                    ->relationship('member', 'username')
                    ->searchable()
                    ->native(false)
                    ->required(),
                Forms\Components\Select::make('outlet_id')
                    ->relationship('outlet', 'name')
                    ->native(false)
                    ->required()
                    ->live(onBlur: true),
                Forms\Components\Select::make('table_id')
                    ->relationship('outlet_tables', 'code', function (Builder $query, Get $get) {
                        $query->where('outlet_id', $get('outlet_id'));
                        $query->where('status', 'available');
                    })
                    ->native(false)
                    ->visible(fn (Get $get) => filled($get('outlet_id')))
                    ->getOptionLabelFromRecordUsing(fn ($record) => $record->floor . ' Floor - Table No:' . $record->code . ' - Max Pax:' . $record->max_pax)
                    ->live(onBlur: true)
                    ->afterStateUpdated(function (Set $set, $state) {
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
                Tables\Columns\TextColumn::make('invoice')
                    ->sortable(),
                Tables\Columns\TextColumn::make('rsvp_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('member.username')
                    ->sortable(),
                Tables\Columns\TextColumn::make('pax_left')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('outlet_tables')
                    ->getStateUsing(function (Rsvp $value) {
                        $re = '<b>' . $value->outlet->name . '</b><br>';
                        $json = json_decode($value->outlet_tables, true);
                        foreach ($json as $key => $value) {
                            $re .= '<li>' . $value['floor'] . " Floor | Table No. " . $value['table'] . " | Price : Rp. " . number_format($value['price']) . " | Max Pax : " . $value['max_pax'] . "</li>";
                        }
                        return $re;
                    })->html(),
                Tables\Columns\TextColumn::make('total')
                    ->numeric()
                    ->sortable()->money('IDR'),
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
                    'issued' => 'info',
                    'waiting_payment' => 'warning',
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
                    Tables\Actions\BulkAction::make('Mark as Paid')
                        ->action(function(Collection $records) {
                            $records->each(function (Rsvp $record) {
                                $record->update([
                                    'payment_status' => 'paid',
                                    'status' => 'issued',
                                ]);


                            Notification::make()
                            ->title('#'.$record->invoice . ' has been paid')
                            ->success()
                            ->send();
                            });
                        })
                        ->deselectRecordsAfterCompletion()
                        ->color('success')
                        ->icon('heroicon-o-check-circle'),
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
