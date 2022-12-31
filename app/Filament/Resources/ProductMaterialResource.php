<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductMaterialResource\Pages;
use App\Models\ProductMaterial;
use Filament\Forms;
use Filament\Resources\{
    Form,
    Resource,
    Table
};
use Filament\Tables;
use Illuminate\Database\Eloquent\{
    Builder,
};

class ProductMaterialResource extends Resource
{
    protected static ?string $model = ProductMaterial::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    protected static ?string $navigationGroup = 'Produk';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make(3)
                    ->schema([
                        Forms\Components\Card::make()
                            ->schema([
                                Forms\Components\TextInput::make('name')
                                    ->autofocus()
                                    ->disableAutocomplete()
                                    ->required()
                                    ->unique(ignoreRecord: true),
                            ])
                            ->columnSpan(2),
                        Forms\Components\Card::make()
                            ->schema([
                                Forms\Components\Placeholder::make('created_at')
                                    ->label('Created at')
                                    ->content(fn (?ProductMaterial $record): string => $record && $record->created_at ? $record->created_at->diffForHumans() : '-'),
                                Forms\Components\Placeholder::make('updated_at')
                                    ->label('Last modified at')
                                    ->content(fn (?ProductMaterial $record): string => $record && $record->updated_at ? $record->updated_at->diffForHumans() : '-'),
                            ])
                            ->columnSpan(1),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('created_at')
                    ->since(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProductMaterials::route('/'),
            'create' => Pages\CreateProductMaterial::route('/create'),
            'edit' => Pages\EditProductMaterial::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->latest('updated_at');
    }
}
