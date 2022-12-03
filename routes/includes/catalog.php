<?php

use App\Http\Controllers\API\General\CatalogController;


Route::group(['middleware' => ['role:superadmin']], function () {
    //
    Route::get('/marcas',[CatalogController::class,'brands'])->middleware(['auth'])->name('catalog.brands');
    Route::get('/brands/get-brand-all', [CatalogController::class, 'getGeneralBrands'])->middleware(['auth'])->name('catalog.brands.get'); // GET BRANDS
    Route::get('/categorias',[CatalogController::class,'categories'])->middleware(['auth'])->name('catalog.categories');
    Route::get('/categories/get-category-all', [CatalogController::class, 'getGeneralCategories'])->middleware(['auth'])->name('catalog.categories.get'); // GET BRANDS
    Route::get('/divisiones',[CatalogController::class,'divisiones'])->middleware(['auth'])->name('catalog.divisiones');
    Route::get('/divisiones/get-division-all', [CatalogController::class, 'getGeneralDivision'])->middleware(['auth'])->name('catalog.division.get'); // GET BRANDS
    Route::resource('catalog', CatalogController::class)->middleware(['auth'])->names('catalog')->except(['destroy']);

});
