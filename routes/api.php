<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\API\Auth\AuthController;
use App\Http\Controllers\API\Auth\ForgotPasswordController;
use Illuminate\Support\Facades\Route;
use  App\Http\Controllers\API\admainController\ProductController;
use App\Http\Controllers\API\Auth\ActivationService;
use App\Http\Controllers\API\OrderController;
use App\Http\Controllers\PaidController;

// Public Routers
// Login && Register
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login'])->name('login');
// Forgot Password
Route::post('password/forgot', [ForgotPasswordController::class, 'forgot']);
Route::post('password/reset', [ForgotPasswordController::class, 'reset']);
// Active User Account
Route::get('user/activation/{token}', [ActivationService::class, 'activateUser'])->name('user.activate');
// About Us
Route::get('/about', [AboutController::class, 'indexApi']);


// Routers With Verified
Route::middleware('verify.account')->group(function () {
    // User Routers
    Route::middleware('auth:api')->group(function () {
        // Change User Information
        Route::post('/user/update', [AuthController::class, 'update']);
        // Order Routers
        Route::get('/orders', [OrderController::class, 'index']);
        Route::post('/orders/store/', [OrderController::class, 'store']);
        Route::put('/orders/update', [OrderController::class, 'update']);
        Route::delete('/orders/destroy/{id}', [OrderController::class, 'destroy']);

        // Paid
        Route::post('/paids/store', [PaidController::class, 'store']);

        // Logout
        Route::post('/logout', [AuthController::class, 'logout']);
    });
});


// routes for create product by admain , show all product , search on products by name ,  delete a product
Route::post('createNewProduct', [ProductController::class, 'create']);
Route::get('showProduct', [ProductController::class, 'showAllProduct']);
Route::get('search/{key}', [ProductController::class, 'search']);
Route::get('deleteProduct/product_id={id}', [ProductController::class, 'destroy']);
Route::post('editProduct/product_id={id}', [ProductController::class, 'update']);
Route::get('deleteProduct/product_id={id}', [ProductController::class, 'show']);
Route::post('addImage_2/product_id={id}', [ProductController::class, 'addImage_2']);
Route::post('addImage_3/product_id={id}', [ProductController::class, 'addImage_3']);
Route::post('addImage_4/product_id={id}', [ProductController::class, 'addImage_4']);
Route::post('addImage_5/product_id={id}', [ProductController::class, 'addImage_5']);
