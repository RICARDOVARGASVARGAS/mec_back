<?php

use App\Http\Controllers\Api\CalculateController;
use App\Http\Controllers\Api\ProductCalculateController;
use App\Http\Controllers\Api\ServiceCalculateController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'auth:api', 'throttle:500,1'], function () {
    Route::post('getCalculates', [CalculateController::class, 'getCalculates'])->name('getCalculates');
    Route::post('getCalculate/{calculate}', [CalculateController::class, 'getCalculate'])->name('getCalculate');
    Route::get('getCalculateDetail/{calculate}', [CalculateController::class, 'getCalculateDetail'])->name('getCalculateDetail');
    Route::post('registerCalculate', [CalculateController::class, 'registerCalculate'])->name('registerCalculate');
    Route::post('updateCalculate/{calculate}', [CalculateController::class, 'updateCalculate'])->name('updateCalculate');
    Route::delete('deleteCalculate/{calculate}', [CalculateController::class, 'deleteCalculate'])->name('deleteCalculate');

    // ProductCalculate
    Route::get('getListProductsCalculate/{calculate}', [ProductCalculateController::class, 'getListProductsCalculate'])->name('getListProductsCalculate');
    Route::post('registerProductCalculate', [ProductCalculateController::class, 'registerProductCalculate'])->name('registerProductCalculate');
    Route::delete('deleteProductCalculate/{productCalculate}', [ProductCalculateController::class, 'deleteProductCalculate'])->name('deleteProductCalculate');

    // ServiceCalculate
    Route::get('getListServicesCalculate/{calculate}', [ServiceCalculateController::class, 'getListServicesCalculate'])->name('getListServicesCalculate');
    Route::post('registerServiceCalculate', [ServiceCalculateController::class, 'registerServiceCalculate'])->name('registerServiceCalculate');
    Route::delete('deleteServiceCalculate/{serviceCalculate}', [ServiceCalculateController::class, 'deleteServiceCalculate'])->name('deleteServiceCalculate');
});
