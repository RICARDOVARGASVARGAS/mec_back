<?php

use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

Route::post('getUsers', [UserController::class, 'getUsers'])->name('getUsers');
Route::post('registerUser', [UserController::class, 'registerUser'])->name('registerUser');
Route::get('getUser/{user}', [UserController::class, 'getUser'])->name('getUser');
Route::put('updateUser/{user}', [UserController::class, 'updateUser'])->name('updateUser');
Route::delete('deleteUser/{user}', [UserController::class, 'deleteUser'])->name('deleteUser');
Route::post('users/{user}/resetPassword', [UserController::class, 'resetPassword'])->name('users.resetPassword');
Route::post('users/{user}/changePassword', [UserController::class, 'changePassword'])->name('users.changePassword');
Route::post('users/updatePermission', [UserController::class, 'updatePermission'])->name('users.updatePermission');
