<?php

use App\Http\Controllers\API\Auth\AuthController;

use Illuminate\Support\Facades\Route;

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
