<?php

use App\Http\Controllers\User\{CartController, CheckoutController, DetailController, HomeController};
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('welcome', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('detail/{product:slug}', DetailController::class)->name('detail.index');

Route::prefix('cart')->name('cart.')->middleware('verified')->controller(CartController::class)->group(function () {
    Route::post('', 'store')->name('store');
    Route::delete('/{cart}', 'destroy')->name('destroy');
});

Route::prefix('checkout')->name('checkout.')->middleware('verified')->controller(CheckoutController::class)->group(function () {
    Route::get('', 'index')->name('index');
    Route::get('district/{province_id}', 'showDistrict')->name('show_district');
});

require __DIR__ . '/auth.php';
