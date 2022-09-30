<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;


//Auth
Route::controller(AuthController::class)->middleware('web')->group(function () {

    Route::middleware('auth')->group(function(){
       
        Route::get('/logout', 'logout')->name('logout');

    });
    
    Route::middleware('guest')->group(function(){

        Route::get('/login', 'showLoginForm')->name('login');

        Route::post('/login', 'loginProcess')->name('loginProcess');

        Route::get('/register', 'showRegisterForm')->name('register');

        Route::post('/register', 'registerProcess')->name('registerProcess');
        
    });

    Route::get('/restore', 'showRestoreForm')->name('restore');

    Route::post('/restore', 'restoreProcess')->name('restoreProcess');

});