<?php

use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

Route::post('getUsers', [UserController::class, 'getUsers'])->name('getUsers');
Route::post('registerUser', [UserController::class, 'registerUser'])->name('registerUser');
Route::get('getUser/{user}', [UserController::class, 'getUser'])->name('getUser');
Route::put('updateUser/{user}', [UserController::class, 'updateUser'])->name('updateUser');
Route::delete('deleteUser/{user}', [UserController::class, 'deleteUser'])->name('deleteUser');
Route::post('resetPassword/{user}', [UserController::class, 'resetPassword'])->name('users.resetPassword');
Route::post('changePassword/{user}', [UserController::class, 'changePassword'])->name('users.changePassword');
Route::post('updatePermission', [UserController::class, 'updatePermission'])->name('users.updatePermission');
Route::get('getModules', [UserController::class, 'getModules'])->name('getModules');
