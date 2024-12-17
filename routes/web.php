<?php

use App\Http\Controllers\UserAuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::controller(UserAuthController::class)->group(function () {
    Route::get('login', 'index')->name('login.view');
    Route::post('auth', 'login')->name('login.auth');
    Route::get('logout', 'logout')->name('logout');
});

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
