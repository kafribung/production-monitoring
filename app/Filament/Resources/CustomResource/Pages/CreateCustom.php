<?php

namespace App\Filament\Resources\CustomResource\Pages;

use App\Filament\Resources\CustomResource;
use Filament\Resources\Pages\CreateRecord;

class CreateCustom extends CreateRecord
{
    protected static string $resource = CustomResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Insert created_by
        $data['created_by'] = auth()->id();

        return $data;
    }
}
