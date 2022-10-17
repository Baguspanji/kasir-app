<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CashierController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ShoppingController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn() => redirect('home'));

Route::controller(LoginController::class)->group(function () {
    Route::get('/login', 'showLoginForm')->name('login');
    Route::post('/login', 'login')->name('login.post');
    Route::post('/logout', 'logout')->name('logout');
});

Route::group(['middleware' => ['auth', 'role:employee']], function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    Route::resource('shopping', ShoppingController::class);

    Route::resource('cashier', CashierController::class);

});

Route::group(['middleware' => ['auth', 'role:employee']], function () {
    Route::resource('item', ItemController::class);
    Route::get('/item/{item}/status', [ItemController::class, 'status'])->name('item.status');
    
    Route::resource('user', UserController::class);
    Route::get('/user/{user}/status', [UserController::class, 'status'])->name('user.status');
});

Route::get('/ajax/item', [ItemController::class, 'ajax'])->name('item.ajax');
Route::get('/ajax/item/{id}', [ItemController::class, 'ajaxById'])->name('item.ajaxById');
