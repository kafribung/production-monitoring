<?php

namespace App\Filament\Resources\CustomResource\Pages;

use App\Filament\Resources\CustomResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCustoms extends ListRecords
{
    protected static string $resource = CustomResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
