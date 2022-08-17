<?php

use App\Http\Controllers\API\General\ProductsController;


Route::group(['middleware' => ['role:superadmin']], function () {
    //
    Route::get('/products',[ProductsController::class,'index'])->middleware(['auth'])->name('index-product');
    Route::get('/products/get-general-all', [ProductsController::class, 'getGeneralProducts'])->middleware(['auth'])->name('products.get'); // TO: GENERAL

});
