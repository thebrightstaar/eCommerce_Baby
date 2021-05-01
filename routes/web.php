<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

// Admin Routers
Route::group(['prefix' => '/admin', 'middleware' => ['auth:api', 'api.admin']], function () {
    // Access Admin Routers
    //
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
