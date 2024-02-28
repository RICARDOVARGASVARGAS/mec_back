<?php

use App\Http\Controllers\Api\CalculateController;
use App\Http\Controllers\ItemCalculateController;
use Illuminate\Support\Facades\Route;

// Route::group(['middleware' => 'auth:api', 'throttle:500,1'], function () {
    Route::post('getCalculates', [CalculateController::class, 'getCalculates'])->name('getCalculates');
    Route::post('getCalculate/{calculate}', [CalculateController::class, 'getCalculate'])->name('getCalculate');
    Route::post('registerCalculate', [CalculateController::class, 'registerCalculate'])->name('registerCalculate');
    Route::post('updateCalculate/{calculate}', [CalculateController::class, 'updateCalculate'])->name('updateCalculate');
    Route::delete('deleteCalculate/{calculate}', [CalculateController::class, 'deleteCalculate'])->name('deleteCalculate');

    // ItemCalculate
    Route::get('getListItemsCalculate/{calculate}', [ItemCalculateController::class, 'getListItemsCalculate'])->name('getListItemsCalculate');
    Route::post('registerItemCalculate', [ItemCalculateController::class, 'registerItemCalculate'])->name('registerItemCalculate');
    Route::delete('deleteItemCalculate/{itemCalculate}', [ItemCalculateController::class, 'deleteItemCalculate'])->name('deleteItemCalculate');
// });
