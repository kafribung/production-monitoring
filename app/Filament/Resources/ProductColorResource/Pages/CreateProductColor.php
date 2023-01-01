<?php

namespace App\Filament\Resources\ProductColorResource\Pages;

use App\Filament\Resources\ProductColorResource;
use Filament\Resources\Pages\CreateRecord;

class CreateProductColor extends CreateRecord
{
    protected static string $resource = ProductColorResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Insert created_by
        $data['created_by'] = auth()->id();

        return $data;
    }
}
