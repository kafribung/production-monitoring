<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Models\Product;
use Closure;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Unique;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';

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
                                    ->reactive()
                                    ->afterStateUpdated(function (Closure $set, $state) {
                                        $set('slug', Str::slug($state, '-'));
                                    })
                                    ->unique(table: Product::class, ignoreRecord: true, callback: function (Unique $rule) {
                                        return $rule->whereNull('deleted_at');
                                    })
                                    ->columnSpanFull(),
                                Forms\Components\TextInput::make('price')
                                    ->required()
                                    ->disableAutocomplete()
                                    ->mask(fn (Forms\Components\TextInput\Mask $mask) => $mask->money(prefix: 'Rp.', thousandsSeparator: ',', decimalPlaces: 2, isSigned: false))
                                    ->columnSpanFull(),
                                Forms\Components\RichEditor::make('description')
                                    ->required()
                                    ->disableToolbarButtons([
                                        'attachFiles',
                                        'codeBlock',
                                        'link',
                                        'strike',
                                    ])
                                    ->columnSpanFull(),
                                Forms\Components\Radio::make('custom')
                                    ->required()
                                    ->reactive()
                                    ->boolean(),
                            ])
                            ->columns(2)
                            ->columnSpan(2),

                        Forms\Components\Section::make('Inventory')
                            ->schema([
                                Forms\Components\TextInput::make('stock_first')
                                    ->required()
                                    ->numeric()
                                    ->disableAutocomplete()
                                    ->mask(
                                        fn (Forms\Components\TextInput\Mask $mask) => $mask
                                            ->minValue(1) // Set the minimum value that the number can be.
                                            ->maxValue(900) // Set the maximum value that the number can be.
                                            ->numeric()
                                    )
                            ])
                            ->columnSpan(1),
                        Forms\Components\Section::make('Associations')
                            ->extraAttributes(['class' => 'row-span-4'])
                            ->schema([
                                Forms\Components\Select::make('material_id')
                                    ->required()
                                    ->relationship('materil', 'name'),
                                Forms\Components\Select::make('category_id')
                                    ->required()
                                    ->relationship('category', 'name'),
                                Forms\Components\CheckboxList::make('colors')
                                    ->required()
                                    ->bulkToggleable()
                                    ->relationship('colors', 'name'),
                                Forms\Components\CheckboxList::make('sizes')
                                    ->required()
                                    ->bulkToggleable()
                                    ->columns(3)
                                    ->relationship('sizes', 'name'),
                                Forms\Components\CheckboxList::make('customs')
                                    ->required()
                                    ->bulkToggleable()
                                    ->columns(3)
                                    ->relationship('customs', 'name')
                                    ->visible(fn ($get) => $get('custom') ?? false)
                            ])
                            ->columns(2)
                            ->columnSpanFull(),

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
                Tables\Columns\TextColumn::make('price')
                    ->money('idr', true)
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('stock_first')
                    ->label('Stock')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('stock_last')
                    ->label('Terjual')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('materil.name')
                    ->label('Material')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('category.name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('customs.name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('colors.name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('sizes.name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created At')
                    ->sortable()
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
            RelationManagers\ImagesRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }

    protected static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }


    // public static function getEloquentQuery(): Builder
    // {
    //     return parent::getEloquentQuery()
    //         ->latest('updated_at');
    // }
}
