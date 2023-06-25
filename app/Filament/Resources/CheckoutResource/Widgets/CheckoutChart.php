<?php

namespace App\Filament\Resources\CheckoutResource\Widgets;

use App\Models\Checkout;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;

class CheckoutChart extends ApexChartWidget
{
    /**
     * Chart Id
     *
     * @var string
     */
    protected static string $chartId = 'grafikPenjualan';

    /**
     * Widget Title
     *
     * @var string|null
     */
    protected static ?string $heading = 'Grafik Penjualan';

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
                ]),
            DatePicker::make('date_start')
                ->default(Carbon::now()->startOfYear()),
            DatePicker::make('date_end')
                ->default(Carbon::now()->endOfYear())

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
        $sale_count  = [];

        // Filter
        $status     = $this->filterFormData['status'];
        $date_start = $this->filterFormData['date_start'];
        $date_end   = $this->filterFormData['date_end'];
        // End Filter

        $datas = Checkout::select(
            DB::raw('year(created_at) as year'),
            DB::raw('month(created_at) as month'),
            DB::raw('MONTHNAME(created_at) as month_name'),
            DB::raw('count(id) as count'),
        )
            ->when($status, function (Builder $query) use ($status) {
                $query->where('status', $status);
            })
            ->when($date_start && $date_end, function (Builder $query) use ($date_start, $date_end) {
                $query->whereBetween('created_at', [$date_start, $date_end]);
            })
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
                    'name' => 'Grafik Penjualan',
                    'data' => $sale_count,
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
        ];
    }
}
