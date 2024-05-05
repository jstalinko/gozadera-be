<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Members',\App\Models\Member::count()),
            Stat::make('Orders',\App\Models\Order::count()),
            Stat::make('Product'  ,\App\Models\Order::count()),
            Stat::make('Omzet' , \App\Models\Order::sum('subtotal'))
        ];
    }

    

   
}
