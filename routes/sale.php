<?php

use App\Http\Controllers\Api\SaleController;
use Illuminate\Support\Facades\Route;

// Route::group(['middleware' => 'auth:api', 'throttle:500,1'], function () {
Route::post('getSales', [SaleController::class, 'getSales'])->name('getSales');
Route::post('getSale/{sale}', [SaleController::class, 'getSale'])->name('getSale');
Route::post('registerSale', [SaleController::class, 'registerSale'])->name('registerSale');
Route::post('updateSale/{sale}', [SaleController::class, 'updateSale'])->name('updateSale');
Route::delete('deleteSale/{sale}', [SaleController::class, 'deleteSale'])->name('deleteSale');

Route::get('getSaleDetail/{sale}', [SaleController::class, 'getSaleDetail'])->name('getSaleDetail');
Route::post('addProduct', [SaleController::class, 'addProduct'])->name('addProduct');
Route::post('removeProduct', [SaleController::class, 'removeProduct'])->name('removeProduct');
Route::post('addService', [SaleController::class, 'addService'])->name('addService');
Route::post('removeService', [SaleController::class, 'removeService'])->name('removeService');
Route::post('addPayment', [SaleController::class, 'addPayment'])->name('addPayment');
Route::post('removePayment', [SaleController::class, 'removePayment'])->name('removePayment');

Route::post('getProfit', [SaleController::class, 'getProfit'])->name('getProfit');
// });
