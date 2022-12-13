<?php

use App\Http\Controllers\API\General\CatalogController;


Route::group(['middleware' => ['role:superadmin|employee']], function () {
    //BRANDS
    Route::get('/marcas',[CatalogController::class,'brands'])->middleware(['auth'])->name('catalog.brands');
    Route::get('/brands/get-brand-all', [CatalogController::class, 'getGeneralBrands'])->middleware(['auth'])->name('catalog.brands.get'); // GET BRANDS
    Route::post('/storebrand',[CatalogController::class,'storebrand'])->middleware(['auth'])->name('catalog.storebrand');

    //CATEGORIES
    Route::get('/categorias',[CatalogController::class,'categories'])->middleware(['auth'])->name('catalog.categories');
    Route::get('/categories/get-category-all', [CatalogController::class, 'getGeneralCategories'])->middleware(['auth'])->name('catalog.categories.get'); // GET BRANDS

    //DIVISION
    Route::get('/divisiones',[CatalogController::class,'divisiones'])->middleware(['auth'])->name('catalog.divisiones');
    Route::get('/divisiones/get-division-all', [CatalogController::class, 'getGeneralDivision'])->middleware(['auth'])->name('catalog.division.get'); // GET BRANDS
    Route::get('/divisiones/delete/{id}', [CatalogController::class, 'deleteDivision'])->middleware(['auth'])->name('catalog.delete.division'); //TO: DELETE
    Route::post('/storedivision',[CatalogController::class,'storedivision'])->middleware(['auth'])->name('catalog.storedivision');

    //PROVIDER
    Route::get('/proveedores',[CatalogController::class,'providers'])->middleware(['auth'])->name('catalog.providers');
    Route::get('/providers/get-provider-all', [CatalogController::class, 'getGeneralProviders'])->middleware(['auth'])->name('catalog.providers.get'); // GET PROVIDER
    Route::post('/storeprovider',[CatalogController::class,'storeProviderAdmin'])->middleware(['auth'])->name('catalog.storeprovider');


    Route::resource('catalog', CatalogController::class)->middleware(['auth'])->names('catalog')->except(['destroy']);

});
