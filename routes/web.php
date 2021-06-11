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
use Illuminate\Support\Facades\App;

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

    // Paids
    Route::get('/paids', [PaidController::class, 'index'])->name('paids.index');
    Route::get('/paids/{id}', [PaidController::class, 'show'])->name('paids.show');
    Route::get('/paids/accept/{id}', [PaidController::class, 'accept'])->name('paids.accept');
    Route::get('/paids/decline/{id}', [PaidController::class, 'decline'])->name('paids.decline');

    // Discounts
    Route::get('/discounts', [DiscountController::class, 'index'])->name('discounts.index');
    Route::post('/discounts/store', [DiscountController::class, 'store'])->name('discounts.store');
    Route::get('/discounts/show/{id}', [DiscountController::class, 'show'])->name('discounts.show');
    Route::get('/discounts/edit/{id}', [DiscountController::class, 'edit'])->name('discounts.edit');
    Route::post('/discounts/update/{id}', [DiscountController::class, 'update'])->name('discounts.update');
    Route::get('/discounts/destroy/{id}', [DiscountController::class, 'destroy'])->name('discounts.destroy');
});


Route::group(['prefix' => '/admin', 'middleware' => 'admin'], function () {

    // Users
    Route::get('/registered_users', [App\Http\Controllers\Admin\DashboardController::class,  'registered_users'])->name('registered_users');
    Route::get('/edit_users/{id}', [App\Http\Controllers\Admin\DashboardController::class,  'edit_users'])->name('edit_users');


});


Route::get('/add_product/store', [ProductController::class, 'create'])->name('product.store');
Route::get('/edit_product/edit/{id}', [ProductController::class, 'edit'])->name('product.edit');
Route::get('/products/show/{id}', [DiscountController::class, 'show'])->name('products.show');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
