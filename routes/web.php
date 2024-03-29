<?php

use App\Http\Controllers\User\{CartController, CategoryController, CheckoutController, DetailController, HomeController, ReviewController};
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
Route::get('category/{category:name}', CategoryController::class)->name('category.index');

Route::middleware('verified')->group(function () {
    // Cart
    Route::prefix('cart')->name('cart.')->controller(CartController::class)->group(function () {
        Route::post('', 'store')->name('store');
        Route::delete('/{cart}', 'destroy')->name('destroy');
    });

    // Checkout
    Route::prefix('checkout')->name('checkout.')->controller(CheckoutController::class)->group(function () {
        Route::get('show', 'show')->name('show');
        Route::post('', 'store')->name('store');
        Route::delete('{checkout}', 'destroy')->name('destroy');
        Route::get('{province_id?}/{dest_id?}', 'index')->name('index');
    });

    // Review
    Route::prefix('review')->name('review.')->controller(ReviewController::class)->group(function () {
        Route::get('show/{checkout_cart}', 'show')->name('show');
        Route::patch('update/{checkout_cart}', 'update')->name('update');
    });
});




require __DIR__ . '/auth.php';
