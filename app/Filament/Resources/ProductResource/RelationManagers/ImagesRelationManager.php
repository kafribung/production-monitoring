<?php

namespace App\Filament\Resources\ProductResource\RelationManagers;

use Carbon\Carbon;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;

class ImagesRelationManager extends RelationManager
{
    protected static string $relationship = 'images';

    protected static ?string $recordTitleAttribute = 'name';

    protected function getTableEmptyStateIcon(): ?string
    {
        return 'heroicon-o-folder-remove';
    }

    protected function getTableEmptyStateHeading(): ?string
    {
        return 'No images yet';
    }

    protected function getTableEmptyStateDescription(): ?string
    {
        return 'You may create a image using the button up.';
    }


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\FileUpload::make('name')
                    ->image()
                    ->imageResizeMode('cover')
                    ->imageCropAspectRatio('4:5')
                    ->imageResizeTargetWidth('1920')
                    ->imageResizeTargetHeight('1080')
                    ->maxSize(1024)
                    ->required()
                    ->getUploadedFileNameForStorageUsing(function ($file): string {
                        return (string)  str($file->getClientOriginalName())->prepend(Carbon::now()->format('Y-m-d') . '/product_images-');
                    })
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('name')
                    ->size(100),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([]);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->latest('creted_by');
    }
}
