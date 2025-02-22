<?php

use App\Http\Controllers\CapacityController;
use App\Http\Controllers\FormController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
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
        Route::post('store', 'store')->name('store');
        Route::get('completed/{order}', 'completed')->name('completed');
    });
});

Route::group(['prefix' => 'payment'], function () {
    Route::controller(PaymentController::class)->name('payment.')->group(function () {
        Route::get('createBill/{orderid}', 'createBill')->name('createBill');
        Route::get('paymentStatus', 'paymentStatus')->name('paymentStatus');
        Route::post('callback', 'callback')->name('callback');
    });
});

Route::group(['prefix' => 'order'], function () {
    Route::controller(OrderController::class)->name('order.')->group(function () {
        Route::put('update/{payment_confirmation_id}', 'update')->name('update');
    });
});

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::group(['prefix' => 'venue'], function () {
        Route::controller(VenueController::class)->name('venue.')->group(function () {
            Route::get('/{venue_id}', 'index')->name('index');
        });
    });

    Route::group(['prefix' => 'capacity'], function () {
        Route::controller(CapacityController::class)->name('capacity.')->group(function () {
            Route::get('create/{venue_id}', 'create')->name('create');
            Route::get('edit/{capacity_id}', 'edit')->name('edit');
            Route::post('store', 'store')->name('store');
        });
    });

    Route::group(['prefix' => 'price'], function () {
        Route::controller(PriceController::class)->name('price.')->group(function () {
            Route::get('create/{venue_id}', 'create')->name('create');
            Route::post('store', 'store')->name('store');
        });
    });

    Route::group(['prefix' => 'order'], function () {
        Route::controller(OrderController::class)->name('order.')->group(function () {
            Route::get('index', 'index')->name('index');
        });
    });
});
