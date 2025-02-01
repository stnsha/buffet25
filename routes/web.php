<?php

use App\Http\Controllers\CapacityController;
use App\Http\Controllers\FormController;
use App\Http\Controllers\PriceController;
use App\Http\Controllers\UserAuthController;
use App\Http\Controllers\VenueController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::controller(UserAuthController::class)->group(function () {
    Route::get('login', 'index')->name('login');
    Route::post('auth', 'login')->name('login.auth');
    Route::get('logout', 'logout')->name('logout');
});

Route::group(['prefix' => 'form'], function () {
    Route::controller(FormController::class)->name('form.')->group(function () {
        Route::get('arena', 'arena')->name('arena');
        Route::get('chermin', 'chermin')->name('chermin');
    });
});

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::group(['prefix' => 'venue'], function () {
        Route::controller(VenueController::class)->name('venue.')->group(function () {
            Route::get('/', 'index')->name('index');
        });
    });

    Route::group(['prefix' => 'capacity'], function () {
        Route::controller(CapacityController::class)->name('capacity.')->group(function () {
            Route::get('create/{venue_id}', 'create')->name('create');
            Route::post('store', 'store')->name('store');
        });
    });

    Route::group(['prefix' => 'price'], function () {
        Route::controller(PriceController::class)->name('price.')->group(function () {
            Route::get('create/{venue_id}', 'create')->name('create');
            Route::post('store', 'store')->name('store');
        });
    });
});
