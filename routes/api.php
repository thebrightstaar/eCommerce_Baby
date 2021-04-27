<?php

use App\Http\Controllers\API\Auth\AuthController;
use App\Http\Controllers\API\Auth\ForgotPasswordController;
use App\Http\Controllers\API\Auth\VerificationController;
use Illuminate\Support\Facades\Route;
use  App\Http\Controllers\API\admainController\ProductController;

// Public Routers
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('password/forgot', [ForgotPasswordController::class, 'forgot']);
Route::post('password/reset', [ForgotPasswordController::class, 'reset']);
Route::get('email/verify/{id}', [VerificationController::class, 'verify'])->name('verification.verify');

// Routers With Verified
Route::middleware('verified')->group(function () {
    // User Routers
    Route::middleware('auth:api')->group(function () {
        // Access User and Admin Routers
    });

    // Admin Routers
    Route::group(['prefix' => '/admin', 'middleware' => ['auth:api', 'api.admin']], function () {
        // Access Admin Routers
    });
});

// Routers Without Verified
Route::middleware('auth:api')->group(function () {
    Route::get('email/resend', [VerificationController::class, 'resend'])->name('verification.resend');
    Route::post('/logout', [AuthController::class, 'logout']);
});

// routes for create product by admain & show all product & search on products by name & delete a product

Route::get('/products', [ProductController::class, 'index']);
Route::post('/products/store', [ProductController::class, 'store']);
Route::get('/search/{key}', [ProductController::class, 'search']);
