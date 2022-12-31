<?php

namespace App\Filament\Resources\ProductMaterialResource\Pages;

use App\Filament\Resources\ProductMaterialResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditProductMaterial extends EditRecord
{
    protected static string $resource = ProductMaterialResource::class;

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
