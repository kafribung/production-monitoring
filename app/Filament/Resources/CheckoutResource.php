<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CheckoutResource\Pages;
use App\Models\Checkout;
use App\Models\Product;
use Filament\Resources\{Form, Resource, Table};
use Filament\{Forms, Tables};
use Filament\Forms\Components\Actions\Action;

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
                Tables\Actions\ViewAction::make()
                    ->mutateRecordDataUsing(function (array $data, Checkout $record): array {
                        // dd($record);
                        $data['user_id'] = auth()->id();
                        $data['checkout_carts'] = [];

                        foreach ($record->checkoutCarts as $checkout_cart) {
                            array_push($data['checkout_carts'], [
                                'product_name' =>  $checkout_cart->cartProduct->name,
                                'color' =>  $checkout_cart->cart->color->hexa,
                                'size' =>  $checkout_cart->cart->size->name,
                                'price' =>  $checkout_cart->cart->price,
                                'quantity' =>  $checkout_cart->cart->quantity,
                                'custom_name' => $checkout_cart->cart->custom ? $checkout_cart->cart->custom->name : null,
                                'note' => $checkout_cart->cart->note
                            ]);
                        };

                        return $data;
                    })->form([
                        Forms\Components\Repeater::make('checkout_carts')
                            ->schema([
                                Forms\Components\TextInput::make('product_name')
                                    ->suffixAction(
                                        function (?string $state): Action {
                                            $product = Product::where('name', $state)->first(['id']);
                                            return Action::make('visit')
                                                ->icon('heroicon-s-external-link')
                                                ->url(
                                                    filled($state) ? config('app.url') . "/admin/products/{$product->id}/edit?activeRelationManager=0" : null,
                                                    shouldOpenInNewTab: true,
                                                );
                                        }
                                    ),
                                Forms\Components\TextInput::make('color'),
                                Forms\Components\TextInput::make('size'),
                                Forms\Components\TextInput::make('price'),
                                Forms\Components\TextInput::make('quantity'),
                                Forms\Components\TextInput::make('custom_name'),
                                Forms\Components\Textarea::make('note'),
                            ])
                            ->disableItemCreation()
                            ->disableItemDeletion()
                            ->disableItemMovement(),

                    ])
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
            // 'view' => Pages\ViewCartCheckout::route('/{record}'),
        ];
    }
}
