<?php

namespace App\Filament\Resources\CheckoutResource\Pages;

use App\Filament\Resources\CheckoutResource;
use App\Filament\Resources\ProductResource\Widgets\ProductChart;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCheckouts extends ListRecords
{
    protected static string $resource = CheckoutResource::class;

    // protected function getActions(): array
    // {
    //     return [
    //         Actions\CreateAction::make(),
    //     ];
    // }

    protected function getHeaderWidgets(): array
    {
        return [
            CheckoutResource\Widgets\CheckoutChart::class,
            ProductChart::class,
        ];
    }

    protected function getHeaderWidgetsColumns(): int | array
    {
        return [
            'sm' => 1,
            'xl' => 2,
        ];
    }
}
