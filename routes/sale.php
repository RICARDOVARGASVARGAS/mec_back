<?php

use App\Http\Controllers\Api\SaleController;
use Illuminate\Support\Facades\Route;

// Route::group(['middleware' => 'auth:api', 'throttle:500,1'], function () {
    Route::post('getSales', [SaleController::class, 'getSales'])->name('getSales');
    Route::post('getSale/{sale}', [SaleController::class, 'getSale'])->name('getSale');
    Route::post('registerSale', [SaleController::class, 'registerSale'])->name('registerSale');
    Route::post('updateSale/{sale}', [SaleController::class, 'updateSale'])->name('updateSale');
    Route::delete('deleteSale/{sale}', [SaleController::class, 'deleteSale'])->name('deleteSale');
// });
