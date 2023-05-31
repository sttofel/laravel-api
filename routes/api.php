<?php

use App\Http\Controllers\Api\EanController;
use App\Http\Controllers\Api\StatusController;
use App\Http\Controllers\Api\TaxController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\ComputerController;
use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\ResellerController;
use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\Auth\ResetPasswordController;

// Auth
Route::post('/login', [AuthController::class, 'auth']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
Route::get('/me', [AuthController::class, 'me'])->middleware('auth:sanctum');
/**
 *
 * Reset Password
 */
Route::post('/forgot-password', [ResetPasswordController::class, 'sendResetLink'])->middleware('guest');
Route::post('/reset-password', [ResetPasswordController::class, 'resetPassword'])->middleware('guest');

Route::get('/', function (){
    return response()->json([
        'success' => true,
    ]);
});

// Public API

Route::group(['prefix' => '/v1'], function () {
    Route::group(['prefix' => '/ean'], function () {
        Route::get('/consulta/{ean}', [EanController::class, 'findByEan']);
        Route::get('/consulta/lista', [EanController::class, 'index']);
    });

    Route::group(['prefix' => '/tabelas'], function () {
        Route::get('/csticms');
        Route::get('/regimes');
    });

    Route::get('/ibpt', [TaxController::class, 'index']);
    Route::get('/ws/{document}', [StatusController::class, 'index']);
});

// Auth protected API
Route::group(['prefix' => '/v2', 'middleware' => 'auth:sanctum'], function () {
    Route::resource('customers', CustomerController::class, ['prefix' => 'customers', 'middleware' => 'isAllowed']);
    Route::resource('users', UserController::class, ['prefix' => 'users', 'middleware' => 'isAdmin']);
    Route::post('users/password/{id}', [UserController::class, 'updatePassword'], ['middleware' => 'isAdmin']);
    Route::resource('resellers', ResellerController::class, ['prefix' => 'resellers', 'middleware' => 'isAdmin']);
    Route::resource('computers', ComputerController::class, ['prefix' => 'computers', 'middleware' => 'isAllowed']);
});
