<?php

use App\Http\Controllers\DiscountController;
use App\Http\Controllers\PaidController;
use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

// Admin Routers
Route::group(['prefix' => '/admin', 'middleware' => 'api.admin'], function () {
    // Access Admin Routers
    Route::get('/payments', [PaymentController::class, 'index'])->name('payments.index');
    Route::get('/payments/create', [PaymentController::class, 'create'])->name('payments.create');
    Route::post('/payments/store', [PaymentController::class, 'store'])->name('payments.store');

    // Paids
    Route::get('/paids', [PaidController::class, 'index'])->name('paids.index');
    Route::get('/paids/{id}', [PaidController::class, 'show'])->name('paids.show');
    Route::get('/paids/accept/{id}', [PaidController::class, 'accept'])->name('paids.accept');
    Route::get('/paids/decline/{id}', [PaidController::class, 'decline'])->name('paids.decline');

    Route::get('/paids/deliver/show', [PaidController::class, 'showAccept'])->name('paids.deliver');
    Route::get('/paids/deliver/confirm/{id}', [PaidController::class, 'confirmDeliver'])->name('paids.deliver.confirm');

    // Discounts
    Route::get('/discounts', [DiscountController::class, 'index'])->name('discounts.index');
    Route::post('/discounts/store', [DiscountController::class, 'store'])->name('discounts.store');
    Route::get('/discounts/show/{id}', [DiscountController::class, 'show'])->name('discounts.show');
    Route::get('/discounts/edit/{id}', [DiscountController::class, 'edit'])->name('discounts.edit');
    Route::post('/discounts/update/{id}', [DiscountController::class, 'update'])->name('discounts.update');
    Route::get('/discounts/destroy/{id}', [DiscountController::class, 'destroy'])->name('discounts.destroy');
});


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
