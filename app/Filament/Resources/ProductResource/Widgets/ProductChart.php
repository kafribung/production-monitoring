<?php

namespace App\Filament\Resources\ProductResource\Widgets;

use App\Models\Product;
use Filament\Forms\Components\Select;
use Illuminate\Database\Eloquent\Builder;
use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;

class ProductChart extends ApexChartWidget
{
    /**
     * Chart Id
     *
     * @var string
     */
    protected static string $chartId = 'productChart';

    /**
     * Widget Title
     *
     * @var string|null
     */
    protected static ?string $heading = 'Produk Laris';

    protected function getFormSchema(): array
    {
        return [
            Select::make('order')
                ->options([
                    'asc' => 'Ascending',
                    'desc' => 'Descending',
                ])
        ];
    }

    /**
     * Chart options (series, labels, types, size, animations...)
     * https://apexcharts.com/docs/options
     *
     * @return array
     */
    protected function getOptions(): array
    {
        // Filter
        $order = $this->filterFormData['order'];
        // End Filter

        $name        = [];
        $stock_last  = [];
        $products = Product::when($order, fn (Builder $query) => $query->orderBy('stock_last', $order))
            ->get(['name', 'stock_last']);

        // Prosess insert data to array
        foreach ($products as $product) {
            array_push($name, $product->name);
            array_push($stock_last, $product->stock_last);
        }

        return [
            'chart' => [
                'type' => 'bar',
                'height' => 300,
            ],
            'series' => [
                [
                    'name' => 'BasicBarChart',
                    'data' => $stock_last,
                ],
            ],
            'xaxis' => [
                'categories' => $name,
                'labels' => [
                    'style' => [
                        'colors' => '#9ca3af',
                        'fontWeight' => 600,
                    ],
                ],
            ],
            'yaxis' => [
                'labels' => [
                    'style' => [
                        'colors' => '#9ca3af',
                        'fontWeight' => 600,
                    ],
                ],
            ],
            'colors' => ['#F59E0B'],
            'plotOptions' => [
                'bar' => [
                    'borderRadius' => 3,
                    'horizontal' => true,
                ],
            ],
        ];
    }
}
