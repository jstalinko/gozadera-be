<?php

namespace App\Filament\Widgets;

use App\Models\Member;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use Filament\Widgets\ChartWidget;

class MemberChart extends ChartWidget
{
    protected static ?string $heading = 'Chart';

    protected static string $color = 'info';

    protected static string $label = 'Members';
    protected static ?int $sort = 2;


    protected function getData(): array
    {
        $data = Trend::model(Member::class)
        ->between(
            start: now()->startOfYear(),
            end: now()->endOfYear(),
        )
        ->perMonth()
        ->count();
 
    return [
        'datasets' => [
            [
                'label' => 'Members Chart',
                'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
            ],
        ],
        'labels' => $data->map(fn (TrendValue $value) => $value->date),
    ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
    protected function getFilters(): ?array
{
    return [
        'today' => 'Today',
        'week' => 'Last week',
        'month' => 'Last month',
        'year' => 'This year',
    ];
}
}
