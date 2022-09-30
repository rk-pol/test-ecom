<?php


use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

//Routs fpr admin panel
require __DIR__ . '/admin.php';

//Routs for user's auth
require __DIR__ . '/auth.php';

//Routs for cart
require __DIR__ . '/cart.php';

/* Rout to main pages */
Route::controller(HomeController::class)->middleware('user_auth')->group(function () {

    Route::get('/', 'index')->name('home');

    Route::get('/{animal_name}', 'showAnimalPage')->whereAlpha('animal_name');

    Route::get('/{animal}/{product_type}', 'showAnimalCategoryPage')->whereAlpha('animal')
                                                                    ->whereAlpha('product_type');

    Route::get('/{animal_name}/{animal_category}/{id_product}', 'showProductPage')->whereAlpha('animal_name')
                                                                                    ->whereAlpha('animal_category')
                                                                                    ->whereNumber('id_product');                                                                  

});


 
Route::get('/page_404', [ErrorController::class, 'index']);

    // Route::get('/cart', 'getAllProducts');
    // Route::get('/cart/{id}', 'getProdPrice')->whereNumber('id');




//Page doesn't exist
// Route::fallback(function () {

//    return redirect('/page_404');

// });

