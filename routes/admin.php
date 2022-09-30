<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AnimalController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductTypeController;
use App\Http\Controllers\ProviderController;
use App\Services\AnimalProductTypeService;
use App\Services\AnimalBrandService;
use App\Services\AdminProductService;
use App\Services\AdminService;
use App\Services\ProviderBrandService;
use Illuminate\Support\Facades\Route;


/* Routs in admin */
Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {   

    Route::get('/', [AdminController::class, 'index']);
     
    Route::post('/all', [AdminController::class, 'all']);

    Route::get('/{id}', [AdminService::class, 'getBrandsProvidersByAnimalId'])->whereNumber('id');

});

/* Routs in admin product's part */
Route::prefix('admin/product')->middleware(['auth', 'admin'])->group(function () {   

    Route::get('/',[ProductController::class, 'index']);

    Route::post('/store',[AdminProductService::class, 'store']);

    Route::post('/update',[AdminProductService::class, 'update']);

    Route::post('/delete',[ProductController::class, 'delete']);

    Route::post('/update',[AdminProductService::class, 'update']);

    Route::get('/edit/{id}',[ProductController::class, 'showEdit'])->whereNumber('id');

    Route::get('/{id}',[AdminProductService::class, 'getDataByIdForSelect'])->whereNumber('id');

});

/* Routs in admin animal's part */
Route::prefix('admin/animal')->middleware(['auth', 'admin'])->group(function () {   

    Route::get('/',[AnimalController::class ,'index']);
   
    //Show
    Route::get('/animals/all',[AnimalController::class, 'all']);

    Route::get('/product_types/all',[ProductTypeController::class, 'all']);
  
    //Store
    Route::post('/animals/store',[AnimalController::class, 'store']);

    Route::post('/product_types/store',[ProductTypeController::class, 'store']);
    
    //Edit
    Route::post('/animals/edit',[AnimalController::class, 'edit']);

    Route::post('/product_types/edit',[ProductTypeController::class, 'edit']);
    
    //Delete
    Route::post('/animals/delete',[AnimalController::class, 'delete']);

    Route::post('/product_types/delete',[ProductTypeController::class, 'delete']);
    
    //Dependecy
    Route::post('/an-cat-dep',[AnimalProductTypeService::class, 'makeDependecy']); 


});

/* Routs in admin provider's part */
Route::prefix('admin/provider')->middleware(['auth', 'admin'])->group(function () {  

    Route::get('/', [ProviderController::class, 'index']);
    
    //Show
    Route::get('/providers/all',[ProviderController::class, 'all']); 

    Route::get('/brands/all',[BrandController::class, 'all']);

    //Store
    Route::post('/providers/store',[ProviderController::class, 'store']);

    Route::post('/brands/store',[BrandController::class, 'store']);

    //Edit
    Route::post('/providers/edit',[ProviderController::class, 'edit']);

    Route::post('/brands/edit',[BrandController::class, 'edit']);

    //Delete
    Route::post('/providers/delete',[ProviderController::class, 'delete']);

    Route::post('/brands/delete',[BrandController::class, 'delete']);

    //Dependecy
    Route::post('/pr-br-dep',[ProviderBrandService::class, 'makeDependecy']); 

    Route::post('/an-br-dep',[AnimalBrandService::class, 'makeDependecy']); 
 
});

