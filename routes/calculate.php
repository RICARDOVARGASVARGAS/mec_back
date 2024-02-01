<?php

use App\Http\Controllers\Api\CalculateController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'auth:api', 'throttle:500,1'], function () {
    Route::post('getCalculates', [CalculateController::class, 'getCalculates'])->name('getCalculates');
    Route::post('getCalculate/{calculate}', [CalculateController::class, 'getCalculate'])->name('getCalculate');
    Route::post('registerCalculate', [CalculateController::class, 'registerCalculate'])->name('registerCalculate');
    Route::post('updateCalculate/{calculate}', [CalculateController::class, 'updateCalculate'])->name('updateCalculate');
    Route::delete('deleteCalculate/{calculate}', [CalculateController::class, 'deleteCalculate'])->name('deleteCalculate');

    Route::get('getCalculateDetail/{calculate}', [CalculateController::class, 'getCalculateDetail'])->name('getCalculateDetail');
    Route::post('addProduct', [CalculateController::class, 'addProduct'])->name('addProduct');
    Route::post('removeProduct', [CalculateController::class, 'removeProduct'])->name('removeProduct');
    Route::post('addService', [CalculateController::class, 'addService'])->name('addService');
    Route::post('removeService', [CalculateController::class, 'removeService'])->name('removeService');
});
