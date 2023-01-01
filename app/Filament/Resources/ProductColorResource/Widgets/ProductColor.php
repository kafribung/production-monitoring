<?php

namespace App\Filament\Resources\ProductColorResource\Widgets;

use App\Models\ProductColor as ModelsProductColor;
use Filament\Widgets\LineChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class ProductColor extends LineChartWidget
{
    protected static ?string $heading = 'Chart';

    protected function getData(): array
    {
        $data = Trend::model(ModelsProductColor::class)
            ->between(
                start: now()->startOfYear(),
                end: now()->endOfYear(),
            )
            ->perMonth()
            ->count();

        return [
            'datasets' => [
                [
                    'label' => 'Blog posts',
                    'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
                ],
            ],
            'labels' => $data->map(fn (TrendValue $value) => $value->date),
        ];
    }
}
