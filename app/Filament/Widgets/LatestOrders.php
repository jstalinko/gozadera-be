<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestOrders extends BaseWidget
{
    protected int | string | array $columnSpan = 'full';
    protected static ?int $sort = 3;
    public function table(Table $table): Table
    {
        return $table
            ->query(
                Order::query()
                    ->latest()
                    ->limit(5)
            )->columns([
                Tables\Columns\TextColumn::make('outlet.name'),
                Tables\Columns\TextColumn::make('outlet_table')->getStateUsing(function (Order $record) {
                    return $record->outlet_table->floor . ' Floor | Table No : '.  $record->outlet_table->code;
                }),
                Tables\Columns\TextColumn::make('member.username'),
                Tables\Columns\TextColumn::make('items')->getStateUsing(function (Order $record) {
                    $items = json_decode($record->items);
                    $html  = '';
                    foreach($items as $item) {
                        $price = number_format($item->price);
                        $name = $item->name;
                        $qty = $item->qty;
                        $html.= '<li>(x'.$qty.') ' . $name . ' -  @' . $price . '</li>';
                    }
                    $html.= '';
                    return $html;
                })->html()->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('subtotal')->money('idr')

            ])->searchable();
            
    }
}
