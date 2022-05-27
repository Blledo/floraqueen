<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CartController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\VoucherController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('/cart')->controller(CartController::class)->group(function() {
    Route::get('/{id?}', 'get');
    Route::post('/', 'create');
    Route::post('/{id}/clear', 'clear');
    Route::delete('/{id}', 'delete');

    Route::prefix('/{id}/product')->group(function() {
        Route::post('/{productId}', 'add');
        Route::put('/{productId}', 'update');
        Route::delete('/{productId}', 'remove');
    });

    Route::prefix('/{id}/voucher')->group(function() {
        Route::post('/{voucherCode}', 'addVoucher');
        Route::delete('/{voucherCode}', 'removeVoucher');
    });
});


Route::prefix('/product')->controller(ProductController::class)->group(function() {
    Route::get('/', 'getAll');
    Route::get('/{id}', 'get');
    Route::post('/', 'create');
    Route::put('/{id}', 'update');
    Route::delete('/{id}', 'delete');
});

Route::prefix('/voucher')->controller(VoucherController::class)->group(function() {
    Route::get('/', 'getAll');
    Route::get('/{id}', 'get');
    Route::post('/', 'create');
    Route::put('/{id}', 'update');
    Route::delete('/{id}', 'delete');

    Route::prefix('/{id}/rules')->group(function() {
        Route::get('/', 'getRules');
        Route::get('/{ruleId}', 'getRule');
        Route::post('/', 'createRule');
        Route::put('/{ruleId}', 'updateRule');
        Route::delete('/{ruleId}', 'removeRule');
    });
});