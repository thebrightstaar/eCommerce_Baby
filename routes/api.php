<?php

use App\Http\Controllers\API\Auth\AuthController;
use App\Http\Controllers\API\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Public Routers
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// User Routers
Route::middleware('auth:api')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
});

// Admin Routers
Route::group(['prefix' => '/admin', 'middleware' => ['auth:api', 'api.admin']], function () {
    // Access Admin Routers
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
