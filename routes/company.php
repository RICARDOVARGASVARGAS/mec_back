<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CompanyController;
use Illuminate\Support\Facades\Route;

Route::post('registerCompany', [CompanyController::class, 'registerCompany'])->name('registerCompany');
Route::post('updateCompany/{company}', [CompanyController::class, 'updateCompany'])->name('updateCompany');
