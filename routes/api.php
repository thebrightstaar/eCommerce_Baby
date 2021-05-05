<?php

use App\Http\Controllers\API\Auth\AuthController;
use App\Http\Controllers\API\Auth\ForgotPasswordController;
use Illuminate\Support\Facades\Route;
use  App\Http\Controllers\API\admainController\ProductController;
use App\Http\Controllers\API\Auth\ActivationService;



// Public Routers
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('password/forgot', [ForgotPasswordController::class, 'forgot']);
Route::post('password/reset', [ForgotPasswordController::class, 'reset']);
Route::get('user/activation/{token}', [ActivationService::class, 'activateUser'])->name('user.activate');


// Routers With Verified
Route::middleware('verify.account')->group(function () {
    // User Routers
    Route::middleware('auth:api')->group(function () {
        // Access User Routers
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
