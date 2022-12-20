<?php

use App\Http\Controllers\API\General\ProductsController;


Route::group(['middleware' => ['role:superadmin|employee']], function () {
    //
    Route::get('/products',[ProductsController::class,'index'])->middleware(['auth'])->name('products.index');
    Route::get('/products/get-general-all', [ProductsController::class, 'getGeneralProducts'])->middleware(['auth'])->name('products.get'); // TO: GENERAL
    Route::get('/create-new-product', [ProductsController::class, 'create'])->middleware(['auth'])->name('products.create');
    Route::get('/product/delete/{id}',[ProductsController::class,'destroy'])->middleware(['auth'])->name('products.destroy');
    Route::get('/product/{id}/edit',[ProductsController::class,'edit'])->middleware(['auth'])->name('products.edit');
    Route::post('/storeproduct',[ProductsController::class,'storeproduct'])->middleware(['auth'])->name('products.storeproduct');
    Route::resource('products', ProductsController::class)->middleware(['auth'])->names('products')->except(['destroy']);

});
