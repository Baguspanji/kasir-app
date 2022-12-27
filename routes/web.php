<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CashierController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn() => redirect('home'));

Route::controller(LoginController::class)->group(function () {
    Route::get('/login', 'showLoginForm')->name('login');
    Route::post('/login', 'login')->name('login.post');
    Route::post('/logout', 'logout')->name('logout');
});

Route::group(['middleware' => ['auth', 'role:admin']], function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/setting', [HomeController::class, 'setting'])->name('setting');
    Route::post('/setting', [HomeController::class, 'updateSetting'])->name('setting.update');

    Route::resource('cashier', CashierController::class);

    Route::resource('item', ItemController::class);
    Route::get('/item/{item}/status', [ItemController::class, 'status'])->name('item.status');

    Route::get('transaction', [TransactionController::class, 'index'])->name('transaction.index');
    Route::get('transaction/income', [TransactionController::class, 'income'])->name('transaction.income');
});

Route::get('/ajax/item', [ItemController::class, 'ajax'])->name('item.ajax');
Route::get('/ajax/item/{id}', [ItemController::class, 'ajaxById'])->name('item.ajaxById');
