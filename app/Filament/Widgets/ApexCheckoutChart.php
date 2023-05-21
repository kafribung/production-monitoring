<?php

namespace App\Filament\Widgets;

use App\Models\Material;
use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;

class ApexCheckoutChart extends ApexChartWidget
{
    /**
     * Chart Id
     *
     * @var string
     */
    protected static string $chartId = 'Material';

    /**
     * Widget Title
     *
     * @var string|null
     */
    protected static ?string $heading = 'Material';

    /**
     * Chart options (series, labels, types, size, animations...)
     * https://apexcharts.com/docs/options
     *
     * @return array
     */
    protected function getOptions(): array
    {
        $materials = Material::get(['name'])->pluck(['name'])->toArray();

        return [
            'chart' => [
                'type' => 'pie',
                'height' => 300,
            ],
            'series' => [2, 4, 6, 10, 14, 10, 74, 12, 63],
            'labels' => $materials,
            'legend' => [
                'labels' => [
                    'colors' => '#9ca3af',
                    'fontWeight' => 600,
                ],
            ],
        ];
    }
}
