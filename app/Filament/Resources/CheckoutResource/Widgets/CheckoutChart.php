<?php

namespace App\Filament\Resources\CheckoutResource\Widgets;

use App\Models\Checkout;
use Filament\Widgets\BarChartWidget;
use Illuminate\Support\Facades\DB;
use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;

class CheckoutChart extends ApexChartWidget
{
    // protected static ?string $heading = 'Grafik Penjualan';

    // protected function getData(): array
    // {
    //     return [
    //         'datasets' => [
    //             [
    //                 'label' => 'Penjualan',
    //                 'data' => [0, 10, 5, 2, 21, 32, 45, 74, 65, 45, 77, 89],
    //             ],
    //         ],
    //         'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
    //     ];
    // }

    /**
     * Chart Id
     *
     * @var string
     */
    protected static string $chartId = 'GrafikPenjualan';

    /**
     * Widget Title
     *
     * @var string|null
     */
    protected static ?string $heading = 'Grafik Penjualan';

    /**
     * Chart options (series, labels, types, size, animations...)
     * https://apexcharts.com/docs/options
     *
     * @return array
     */
    protected function getOptions(): array
    {
        $month_names = [];
        $sale_count  = [];
        $datas = Checkout::select(
            DB::raw('year(created_at) as year'),
            DB::raw('month(created_at) as month'),
            DB::raw('MONTHNAME(created_at) as month_name'),
            DB::raw('count(id) as count'),
        )
            ->groupBy(['year', 'month', 'month_name'])
            ->orderBy('month', 'asc')
            ->get();

        // Prosess insert data to array
        foreach ($datas as $data) {
            array_push($month_names, $data->month_name);
            array_push($sale_count, $data->count);
        }

        return [
            'chart' => [
                'type' => 'bar',
                'height' => 300,
            ],
            'series' => [
                [
                    'name' => 'BlogPostsChart',
                    'data' => $sale_count,
                ],
            ],
            'xaxis' => [
                'categories' => $month_names,
                'labels' => [
                    'style' => [
                        'colors' => '#fff',
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
            'colors' => ['#6366f1'],
        ];
    }
}
