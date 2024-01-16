<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CompanyController;
use Illuminate\Support\Facades\Route;

Route::get('getCompany/{company}', [CompanyController::class, 'getCompany'])->name('getCompany');
Route::post('registerCompany', [CompanyController::class, 'registerCompany'])->name('registerCompany');
Route::put('updateCompany/{company}', [CompanyController::class, 'updateCompany'])->name('updateCompany');
