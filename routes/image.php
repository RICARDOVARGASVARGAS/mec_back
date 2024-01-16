<?php

use App\Http\Controllers\Api\ImageController;
use Illuminate\Support\Facades\Route;

Route::post('uploadFile', [ImageController::class, 'uploadFile'])->name('uploadFile');
Route::post('uploadImageMany', [ImageController::class, 'uploadImageMany'])->name('uploadImageMany');
Route::post('deleteImageMany', [ImageController::class, 'deleteImageMany'])->name('deleteImageMany');
