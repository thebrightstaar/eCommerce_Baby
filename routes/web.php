<?php

use App\Http\Controllers;
use App\Http\Controllers\DiscountController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PaidController;
use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\ContactController;

Auth::routes();

Route::get('/', function () {
    return view('welcome');
});

//dashboard
Route::get('/dashboard', function () {
    return view('layouts.main');
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

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

    // Contact
    Route::get('/user/contact', [ContactController::class, 'index'])->name('contact.index');
    Route::get('/user/contact/{id}', [ContactController::class, 'open'])->name('contact.open');
    Route::post('/user/contact/send/{id}', [ContactController::class, 'send'])->name('contact.send');
});


Route::group(['prefix' => '/admin', 'middleware' => 'admin'], function () {

    // Users
    Route::get('/registered_users', [App\Http\Controllers\Admin\DashboardController::class,  'registered_users'])->name('registered_users');
    Route::get('/edit_users/{id}', [App\Http\Controllers\Admin\DashboardController::class,  'edit_users'])->name('edit_users');
});

// Product
Route::get('/add_product/store', [ProductController::class, 'create'])->name('product.store');
Route::get('/edit_product/edit/{id}', [ProductController::class, 'edit'])->name('product.edit');
Route::get('products/show/{id}', [ProductController::class, 'show'])->name('product.show');


// // // Category
Route::get('/categories', [App\Http\Controllers\CategoryController::class , 'index'])->name('categories.index');
Route::get('/cateogry/create', [CategoryController::class , 'create'])->name('categories.create');
Route::get('/category/store', [CategoryController::class , 'store'])->name('categories.store');
Route::get('/category/edit/{id}', [CategoryController::class , 'edit'])->name('categories.edit');
Route::post('/category/update/{id}', [CategoryController::class, 'update'])->name('categories.update');
Route::get('/category/destroy/{id}', [CategoryController::class, 'destroy'])->name('categories.destroy');

