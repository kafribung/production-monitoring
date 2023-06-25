<?php

namespace App\Filament\Resources\CheckoutResource\Widgets;

use App\Models\Checkout;
use Filament\Forms\Components\Select;
use Illuminate\Support\Facades\DB;
use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;

class SubtotalCheckoutChart extends ApexChartWidget
{
    /**
     * Chart Id
     *
     * @var string
     */
    protected static string $chartId = 'Total';

    /**
     * Widget Title
     *
     * @var string|null
     */
    protected static ?string $heading = 'Total Pendapatan';

    protected function getFormSchema(): array
    {
        return [
            Select::make('status')
                ->options([
                    'success' => 'Success',
                    'pending' => 'Pending',
                    'deny'    => 'Deny',
                    'expire'  => 'Expire',
                    'cancel'  => 'Cancel',
                ])->default('success'),

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
        $month_names = [];
        $total_sums  = [];
        $checkout = Checkout::select(
            DB::raw('year(created_at) as year'),
            DB::raw('month(created_at) as month'),
            DB::raw('MONTHNAME(created_at) as month_name'),
            DB::raw('sum(total) as total'),
        )
            ->where('status', $this->filterFormData['status'])
            ->groupBy(['year', 'month', 'month_name'])
            ->orderBy('month', 'asc')
            ->get();

        // Prosess insert data to array
        foreach ($checkout as $data) {
            array_push($month_names, $data->month_name);
            array_push($total_sums, $data->total);
        }

        return [
            'chart' => [
                'type' => 'line',
                'height' => 300,
            ],
            'series' => [
                [
                    'name' => 'Rupiah',
                    'data' => $total_sums,
                ],
            ],
            'xaxis' => [
                'categories' => $month_names,
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
            'stroke' => [
                'curve' => 'smooth',
            ],
        ];
    }
}
