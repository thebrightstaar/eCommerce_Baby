<?php

use App\Http\Controllers\DiscountController;
use App\Http\Controllers\PaidController;
use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\Admin\DashboardController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

// Admin Routers
Route::group(['prefix' => '/admin', 'middleware' => 'admin'], function () {
    // Access Admin Routers
    Route::get('/payments', [PaymentController::class, 'index'])->name('payments.index');
    Route::get('/payments/create', [PaymentController::class, 'create'])->name('payments.create');
    Route::post('/payments/store', [PaymentController::class, 'store'])->name('payments.store');
    Route::get('/payments/destroy/{id}', [PaymentController::class, 'destroy'])->name('payments.destroy');

    // Paids
    Route::get('/paids', [PaidController::class, 'index'])->name('paids.index');
    Route::get('/paids/{id}', [PaidController::class, 'show'])->name('paids.show');
    Route::get('/paids/accept/{id}', [PaidController::class, 'accept'])->name('paids.accept');
    Route::get('/paids/decline/{id}', [PaidController::class, 'decline'])->name('paids.decline');

    Route::get('/paids/deliver/show', [PaidController::class, 'showAccept'])->name('paids.deliver');
    Route::get('/paids/deliver/confirm/{id}', [PaidController::class, 'confirmDeliver'])->name('paids.deliver.confirm');
    Route::get('/paids/deliver/decline', [PaidController::class, 'showDecline'])->name('paids.decline');

    // Discounts
    Route::get('/discounts', [DiscountController::class, 'index'])->name('discounts.index');
    Route::post('/discounts/store', [DiscountController::class, 'store'])->name('discounts.store');
    Route::get('/discounts/show/{id}', [DiscountController::class, 'show'])->name('discounts.show');
    Route::get('/discounts/edit/{id}', [DiscountController::class, 'edit'])->name('discounts.edit');
    Route::post('/discounts/update/{id}', [DiscountController::class, 'update'])->name('discounts.update');
    Route::get('/discounts/destroy/{id}', [DiscountController::class, 'destroy'])->name('discounts.destroy');

    // About Us
    Route::get('/about', [AboutController::class, 'index'])->name('about.index');
    Route::post('/about/store', [AboutController::class, 'store'])->name('about.store');
    Route::get('/about/edit/{id}', [AboutController::class, 'edit'])->name('about.edit');
    Route::post('/about/update/{id}', [AboutController::class, 'update'])->name('about.update');
    Route::get('/about/destroy/{id}', [AboutController::class, 'destroy'])->name('about.destroy');
});


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::get('/dashboard', function () {
    return view('Admin.dashboard');
});


Route::get('/registered_users', [App\Http\Controllers\Admin\DashboardController::class,  'registered_users'])->name('registered_users');
Route::get('/edit_users/{id}', [App\Http\Controllers\Admin\DashboardController::class,  'edit_users'])->name('edit_users');
