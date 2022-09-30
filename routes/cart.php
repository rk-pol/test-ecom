<?php

use App\Http\Controllers\CartController;
use Illuminate\Support\Facades\Route;

/* Routs in admin */
Route::prefix('cart')->controller(CartController::class)->group(function () {   

    Route::get('/all', 'all');

    Route::get('/check', 'check');

    Route::post('/store', 'store');

    Route::post('/update', 'update');

    Route::get('/order', 'makeOrder');

    Route::post('/buy', 'orderProcess');

    Route::post('/incrementAmount', 'incrementAmount');

    Route::post('/decrementAmount', 'decrementAmount');

    Route::post('/delete', 'delete');

});
