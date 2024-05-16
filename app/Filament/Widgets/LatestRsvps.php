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
                ->getStateUsing(function (Rsvp $value){ 
                    $re = '<b>'.$value->outlet->name.'</b><br>';
                     $json = json_decode($value->outlet_tables, true);
                     foreach($json as $key => $value){
                         $re .= '<li>'.$value['floor']." Floor | Table No. ".$value['table']." | Price : Rp. ".number_format($value['price'])." | Max Pax : ".$value['max_pax']."</li>";
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
                    'issued' => 'primary',
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
            ]);
    }
}
