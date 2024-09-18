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
use Filament\Tables\Filters\SelectFilter;

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
                    ->required()->native(false),
                Forms\Components\TextInput::make('invoice')->readonly(),
                Forms\Components\DatePicker::make('rsvp_date')
                    ->required(),
                Forms\Components\TextInput::make('total')->numeric(),
                Forms\Components\Select::make('payment_status')
                    ->options([
                        'unpaid' => 'Unpaid',
                        'paid' => 'Paid',
                        'expired' => 'Expired',
                        'cancelled' => 'Cancelled',
                    ])
                    ->required()
                    ->native(false),
                Forms\Components\TextInput::make('pax_left')->required(),
            ]);
    }
    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('invoice')
                    ->sortable()
                    ->searchable(),
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
                Tables\Columns\BadgeColumn::make('payment_status')->color(fn(string $state): string => match ($state) {
                    'unpaid' => 'danger',
                    'paid' => 'success',
                    'expired' => 'grey',
                    'cancelled' => 'grey',
                })
                    ->sortable(),
                Tables\Columns\BadgeColumn::make('status')->color(fn(string $state): string => match ($state) {
                    'check_in' => 'success',
                    'check_out' => 'danger',
                    'cancelled' => 'grey',
                    'expired' => 'grey',
                    'issued' => 'info',
                    'waiting_payment' => 'warning',
                })
                    ->sortable(),
                Tables\Columns\TextColumn::make('proofTransfer')
                    ->label('Proof Transfer')
                    ->getStateUsing(function ($record) {
                        $proofTransfer = $record->proofTransfer;
                        return $proofTransfer ? '<a href="' . $proofTransfer->image . '" target="_blank" class="btn">Lihat Bukti</a>' : 'No Proof';
                    })->html(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('id','desc')
            ->filters([
                SelectFilter::make('payment_status')
                ->options([
                    'unpaid' => 'Unpaid',
                    'paid' => 'Paid',
                    'canceled' => 'Canceled',
                    'expired' => 'Expired',
                ])
                ->label('Payment Status'),
                SelectFilter::make('proof_transfer')
    ->label('Proof Transfer')
    ->options([
        'with_proof' => 'Bukti Transfer',  // Records with proof_transfer
        'no_proof' => 'No Proof',          // Records without proof_transfer
    ])
    ->query(function (Builder $query, $state) {
         // Check if 'with_proof' or 'no_proof' is being passed
        if ($state['value'] === 'with_proof') {
            $query->whereHas('proofTransfer');
        } elseif ($state['value'] === 'no_proof') {
            $query->whereDoesntHave('proofTransfer');
        }
    }),
    


            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\BulkAction::make('Mark as Paid')
                        ->action(function (Collection $records) {
                            $records->each(function (Rsvp $record) {
                                $record->update([
                                    'payment_status' => 'paid',
                                    'status' => 'issued',
                                ]);


                                Notification::make()
                                    ->title('#' . $record->invoice . ' has been paid')
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
