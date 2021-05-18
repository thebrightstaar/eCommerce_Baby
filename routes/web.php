<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers;
use App\Http\Controllers\Admin\DashboardController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

// Admin Routers
Route::group(['prefix' => '/admin', 'middleware' => 'admin'], function () {
    // Access Admin Routers
    //
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::get('/dashboard', function () {
    return view('Admin.dashboard');
});


Route::get('/registered_users', [App\Http\Controllers\Admin\DashboardController::class,  'registered_users'])->name('registered_users');
Route::get('/edit_users/{id}', [App\Http\Controllers\Admin\DashboardController::class,  'edit_users'])->name('edit_users');
