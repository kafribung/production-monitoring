<?php

namespace App\Providers;

use Filament\Facades\Filament;
use Filament\Navigation\NavigationGroup;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Filament::serving(function () {
            Filament::registerNavigationGroups([
                NavigationGroup::make()
                    ->label('Produk')
                    ->icon('heroicon-s-shopping-cart'),
                NavigationGroup::make()
                    ->label('Penjualan')
                    ->icon('heroicon-s-cash'),
                NavigationGroup::make()
                    ->label('Pengguna')
                    ->icon('heroicon-s-cog')
                    ->collapsed(),
            ]);
        });
    }
}
