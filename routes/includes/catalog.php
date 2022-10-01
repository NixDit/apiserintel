<?php

use App\Http\Controllers\API\General\CatalogController;


Route::group(['middleware' => ['role:superadmin']], function () {
    //
    Route::get('/marcas',[CatalogController::class,'brands'])->middleware(['auth'])->name('catalog.brands');
    Route::get('/categorias',[CatalogController::class,'categories'])->middleware(['auth'])->name('catalog.categories');
    Route::resource('catalog', CatalogController::class)->middleware(['auth'])->names('catalog')->except(['destroy']);

});
