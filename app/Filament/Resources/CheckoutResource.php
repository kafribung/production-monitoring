<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CheckoutResource\Pages;
use App\Models\Checkout;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;

class CheckoutResource extends Resource
{
    protected static ?string $model = Checkout::class;

    protected static ?string $navigationIcon = 'heroicon-o-credit-card';

    protected static ?string $navigationGroup = 'Penjualan';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('order_number')
                    ->searchable(isIndividual: true, isGlobal: false),
                Tables\Columns\TextColumn::make('createdBy.name')
                    ->label('customer')
                    ->searchable(),
                Tables\Columns\TextColumn::make('address')
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone')
                    ->searchable(),
                Tables\Columns\TextColumn::make('subtotal')
                    ->searchable()
                    ->sortable()
                    ->money('IDR', true),
                Tables\Columns\TextColumn::make('shipping')
                    ->searchable()
                    ->sortable()
                    ->money('IDR', true),
                Tables\Columns\TextColumn::make('total')
                    ->searchable()
                    ->sortable()
                    ->money('IDR', true),
                Tables\Columns\BadgeColumn::make('status')
                    ->searchable()
                    ->colors([
                        'primary'  => 'expire',
                        'secondary' => 'pending',
                        'warning' => 'deny',
                        'success' => 'success',
                        'danger' => 'cancel',
                    ]),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Order Date')
                    ->sortable()
            ])
            ->filters([
                //
            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                // Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListCheckouts::route('/'),
            // 'create' => Pages\CreateCheckout::route('/create'),
            // 'edit' => Pages\EditCheckout::route('/{record}/edit'),
        ];
    }
}
