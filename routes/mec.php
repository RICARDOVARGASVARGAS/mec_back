<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\YearController;
use Illuminate\Support\Facades\Route;


Route::post('getYears', [YearController::class, 'getYears'])->name('getYears');
Route::post('getYear/{year}', [YearController::class, 'getYear'])->name('getYear');
Route::post('registerYear', [YearController::class, 'registerYear'])->name('registerYear');
Route::post('updateYear/{year}', [YearController::class, 'updateYear'])->name('updateYear');
Route::delete('deleteYear/{year}', [YearController::class, 'deleteYear'])->name('deleteYear');
