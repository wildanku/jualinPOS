<?php

use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\ProductController as ApiProductController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PosController;
use App\Http\Controllers\ProductController;
use App\Models\Product;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::middleware('auth')->group(function() {
    
    Route::controller(PosController::class)->prefix('pos')->group(function() {
        Route::get('/', 'index')->name('pos.index');
    });

    Route::prefix('dashboard')->group(function() {
        Route::get('/', [DashboardController::class,'index'])->name('dashboard');
        Route::resource('product',ProductController::class);
    });

    Route::prefix('ajax')->name('ajax.')->group(function() {
        Route::get('/products', [ApiProductController::class, 'productsPos'])->name('products');
        
        Route::controller(CartController::class)->prefix('cart')->name('cart.')->group(function() {
            Route::get('/', 'get')->name('get');
            Route::post('/', 'create')->name('create');
            Route::post('/delete-cart', 'clear')->name('delete');
        });
    });
});

require __DIR__.'/auth.php';
