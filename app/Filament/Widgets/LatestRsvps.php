<?php

namespace App\Filament\Widgets;

use App\Models\Rsvp;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestRsvps extends BaseWidget
{
    protected int | string | array $columnSpan = 'full';
        protected static ?int $sort = 4;
    public function table(Table $table): Table
    {
        
        return $table
            ->query(
                Rsvp::query()
                    ->latest()
                    ->limit(5)
            )
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
            ]);
    }
}
