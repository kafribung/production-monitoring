<?php

namespace App\Filament\Resources\CheckoutResource\Widgets;

use Filament\Widgets\BarChartWidget;

class CheckoutChart extends BarChartWidget
{
    protected static ?string $heading = 'Grafik Penjualan';

    protected function getData(): array
    {
        return [
            'datasets' => [
                [
                    'label' => 'Penjualan',
                    'data' => [0, 10, 5, 2, 21, 32, 45, 74, 65, 45, 77, 89],
                ],
            ],
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        ];
    }
}
