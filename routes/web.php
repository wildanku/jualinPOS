<?php

use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\PosTransactionController;
use App\Http\Controllers\Api\ProductController as ApiProductController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PosController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TaxController;
use App\Http\Controllers\UserManagementController;
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
        Route::post('/', 'storeTransaction')->name('pos.store-transaction');
        
        Route::get('/transactions','transactions')->name('pos.transactions');
        Route::get('/show-transaction/{posTransaction}','showTransactions')->name('pos.transaction.show');
        Route::get('/transaction/{posTransaction}', 'showTransaction')->name('pos.show-transaction');

    });

    Route::prefix('dashboard')->group(function() {
        Route::get('/', [DashboardController::class,'index'])->name('dashboard');
    });


    Route::resource('product',ProductController::class);

    Route::post('/product/import', [ProductController::class,'import'])->name('product.import');

    Route::prefix('setting')->group(function() {

        Route::controller(SettingController::class)->group(function() {
            Route::get('/general','general')->name('setting.general');
            Route::post('/general','updateGeneral')->name('setting.general.update');
            Route::resource('taxes',TaxController::class)->except('show','edit','create');
        });

        Route::controller(UserManagementController::class)->prefix('user')->group(function() {
            Route::get('/','index')->name('setting.user.index');
            Route::post('/','store')->name('setting.user.store');
            Route::delete('/{user}','destroy')->name('setting.user.destroy');
            Route::put('/{user}/update','update')->name('setting.user.update');
            Route::put('/{user}/update-pass','updatePass')->name('setting.user.update-pass');
        });

    });

    Route::prefix('ajax')->name('ajax.')->group(function() {
        Route::controller(ApiProductController::class)->prefix('product')->name('product.')->group(function() {
            Route::get('/products', 'productsPos')->name('get');
            Route::get('/product-custom','getCustomProduct')->name('custom');
            Route::post('/product-custom/create','createCustomProduct')->name('custom.create');
        });
        
        Route::controller(CartController::class)->prefix('cart')->name('cart.')->group(function() {
            Route::get('/', 'get')->name('get');
            Route::post('/', 'create')->name('create');
            Route::post('/createCustom', 'createCustom')->name('create.custom');
            Route::post('/delete-cart', 'clear')->name('delete');

            Route::post('/add-custom-cart', 'addCustomCart')->name('customCart');
        });

        Route::controller(PosTransactionController::class)->prefix('pos')->group(function() {
            Route::get('/incomes','getIncome')->name('pos.income');
            Route::get('/product-best-selling','productBestSelling')->name('pos.product-best-selling');
        });
    });
});

require __DIR__.'/auth.php';
