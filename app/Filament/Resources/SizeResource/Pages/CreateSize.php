<?php

namespace App\Filament\Resources\SizeResource\Pages;

use App\Filament\Resources\SizeResource;
use Filament\Resources\Pages\CreateRecord;

class CreateSize extends CreateRecord
{
    protected static string $resource = SizeResource::class;

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
