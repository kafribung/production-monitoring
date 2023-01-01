<?php

namespace App\Filament\Resources\ProductColorResource\Pages;

use App\Filament\Resources\ProductColorResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditProductColor extends EditRecord
{
    protected static string $resource = ProductColorResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $data['updated_by'] = auth()->id();

        return $data;
    }
}
