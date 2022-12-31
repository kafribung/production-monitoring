<?php

namespace App\Filament\Resources\ProductMaterialResource\Pages;

use App\Filament\Resources\ProductMaterialResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListProductMaterials extends ListRecords
{
    protected static string $resource = ProductMaterialResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
