<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\HomeController;
use App\Http\Controllers\Api\ItemController;
use App\Http\Controllers\Api\TransactionController;
use App\Http\Controllers\Api\UploadController;
use Illuminate\Support\Facades\Route;

Route::controller(AuthController::class)->group(function () {
    Route::post('/login', 'login');
    Route::group(['middleware' => ['auth:sanctum']], function () {
        Route::get('/logout', 'logout');
        Route::get('/user', 'user');
        Route::post('/change-password', 'changePassword');
        // Route::post('/change-profile', 'changeProfile');
    });
});

Route::group(['middleware' => ['auth:users']], function () {
    Route::get('/dashboard', [HomeController::class, 'index']);

    Route::apiResource('item', ItemController::class)->except(['destroy']);
    Route::post('item/{item}/status', [ItemController::class, 'status']);

    Route::apiResource('transaction', TransactionController::class)->except(['update', 'destroy']);
    Route::get('transaction-income/', [TransactionController::class, 'income']);
    Route::get('transaction-income/{transaction}', [TransactionController::class, 'incomeById']);
});

Route::get('/terms-condition', [HomeController::class, 'getTNC']);
Route::post('/upload', [UploadController::class, 'uploadFile']);
