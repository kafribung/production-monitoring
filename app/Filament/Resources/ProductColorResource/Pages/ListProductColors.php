<?php

namespace App\Filament\Resources\ProductColorResource\Pages;

use App\Filament\Resources\ProductColorResource;
use App\Filament\Resources\ProductColorResource\Widgets\ProductColor;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListProductColors extends ListRecords
{
    protected static string $resource = ProductColorResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    // protected function getHeaderWidgets(): array
    // {
    //     return [
    //         ProductColor::class,
    //     ];
    // }
}
