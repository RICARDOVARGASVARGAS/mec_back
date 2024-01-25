<?php


use App\Http\Controllers\Api\BoxController;
use App\Http\Controllers\Api\BrandController;
use App\Http\Controllers\Api\CarController;
use App\Http\Controllers\Api\ClientController;
use App\Http\Controllers\Api\ColorController;
use App\Http\Controllers\Api\ExampleController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\ServiceController;
use App\Http\Controllers\Api\YearController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'auth:api', 'throttle:500,1'], function () {

    Route::post('getBrands', [BrandController::class, 'getBrands'])->name('getBrands');
    Route::post('getBrand/{brand}', [BrandController::class, 'getBrand'])->name('getBrand');
    Route::post('registerBrand', [BrandController::class, 'registerBrand'])->name('registerBrand');
    Route::post('updateBrand/{brand}', [BrandController::class, 'updateBrand'])->name('updateBrand');
    Route::delete('deleteBrand/{brand}', [BrandController::class, 'deleteBrand'])->name('deleteBrand');

    Route::post('getColors', [ColorController::class, 'getColors'])->name('getColors');
    Route::post('getColor/{color}', [ColorController::class, 'getColor'])->name('getColor');
    Route::post('registerColor', [ColorController::class, 'registerColor'])->name('registerColor');
    Route::post('updateColor/{color}', [ColorController::class, 'updateColor'])->name('updateColor');
    Route::delete('deleteColor/{color}', [ColorController::class, 'deleteColor'])->name('deleteColor');

    Route::post('getExamples', [ExampleController::class, 'getExamples'])->name('getExamples');
    Route::post('getExample/{example}', [ExampleController::class, 'getExample'])->name('getExample');
    Route::post('registerExample', [ExampleController::class, 'registerExample'])->name('registerExample');
    Route::post('updateExample/{example}', [ExampleController::class, 'updateExample'])->name('updateExample');
    Route::delete('deleteExample/{example}', [ExampleController::class, 'deleteExample'])->name('deleteExample');

    Route::post('getYears', [YearController::class, 'getYears'])->name('getYears');
    Route::post('getYear/{year}', [YearController::class, 'getYear'])->name('getYear');
    Route::post('registerYear', [YearController::class, 'registerYear'])->name('registerYear');
    Route::post('updateYear/{year}', [YearController::class, 'updateYear'])->name('updateYear');
    Route::delete('deleteYear/{year}', [YearController::class, 'deleteYear'])->name('deleteYear');

    Route::post('getProducts', [ProductController::class, 'getProducts'])->name('getProducts');
    Route::post('getProduct/{product}', [ProductController::class, 'getProduct'])->name('getProduct');
    Route::post('registerProduct', [ProductController::class, 'registerProduct'])->name('registerProduct');
    Route::post('updateProduct/{product}', [ProductController::class, 'updateProduct'])->name('updateProduct');
    Route::delete('deleteProduct/{product}', [ProductController::class, 'deleteProduct'])->name('deleteProduct');

    Route::post('getServices', [ServiceController::class, 'getServices'])->name('getServices');
    Route::post('getService/{service}', [ServiceController::class, 'getService'])->name('getService');
    Route::post('registerService', [ServiceController::class, 'registerService'])->name('registerService');
    Route::post('updateService/{service}', [ServiceController::class, 'updateService'])->name('updateService');
    Route::delete('deleteService/{service}', [ServiceController::class, 'deleteService'])->name('deleteService');

    Route::post('getBoxes', [BoxController::class, 'getBoxes'])->name('getBoxes');
    Route::post('getBox/{box}', [BoxController::class, 'getBox'])->name('getBox');
    Route::post('registerBox', [BoxController::class, 'registerBox'])->name('registerBox');
    Route::post('updateBox/{box}', [BoxController::class, 'updateBox'])->name('updateBox');
    Route::delete('deleteBox/{box}', [BoxController::class, 'deleteBox'])->name('deleteBox');

    Route::post('getClients', [ClientController::class, 'getClients'])->name('getClients');
    Route::post('getClient/{client}', [ClientController::class, 'getClient'])->name('getClient');
    Route::post('registerClient', [ClientController::class, 'registerClient'])->name('registerClient');
    Route::post('updateClient/{client}', [ClientController::class, 'updateClient'])->name('updateClient');
    Route::delete('deleteClient/{client}', [ClientController::class, 'deleteClient'])->name('deleteClient');

    Route::post('getCars', [CarController::class, 'getCars'])->name('getCars');
    Route::post('getCar/{car}', [CarController::class, 'getCar'])->name('getCar');
    Route::post('registerCar', [CarController::class, 'registerCar'])->name('registerCar');
    Route::post('updateCar/{car}', [CarController::class, 'updateCar'])->name('updateCar');
    Route::delete('deleteCar/{car}', [CarController::class, 'deleteCar'])->name('deleteCar');
});
