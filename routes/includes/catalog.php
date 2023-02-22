<?php

use App\Http\Controllers\API\General\BrandController;
use App\Http\Controllers\API\General\CatalogController;
use App\Http\Controllers\API\General\CategoryController;
use App\Http\Controllers\API\General\DivisionController;
use App\Http\Controllers\API\General\ProviderController;
use App\Http\Controllers\API\General\CompanyserviceController;
use App\Http\Controllers\API\General\CompanycellphoneController;


Route::group(['middleware' => ['role:superadmin|employee']], function () {
    //BRANDS
    Route::get('/marcas',[BrandController::class,'index'])->middleware(['auth'])->name('catalog.brand.index');
    Route::get('/brands/get-brand-all', [BrandController::class, 'getGeneralBrands'])->middleware(['auth'])->name('catalog.brand.get'); // GET BRANDS
    Route::get('/brands/delete/{id}',[BrandController::class,'deleteBrand'])->middleware(['auth'])->name('catalog.brand.destroybrand');
    Route::get('/brands/{id}/edit',[BrandController::class,'edit'])->middleware(['auth'])->name('catalog.brand.edit');
    Route::post('/storebrand',[BrandController::class,'store'])->middleware(['auth'])->name('catalog.brand.store');
    Route::resource('marcas', BrandController::class)->middleware(['auth'])->names('catalog.brand')->except(['destroy']);

    //CATEGORIES
    Route::get('/categorias',[CategoryController::class,'index'])->middleware(['auth'])->name('catalog.categories.index');
    Route::get('/categories/get-category-all', [CategoryController::class, 'getGeneralCategories'])->middleware(['auth'])->name('catalog.categories.get'); // GET BRANDS
    Route::get('/categories/delete/{id}',[CategoryController::class,'delete'])->middleware(['auth'])->name('catalog.categories.delete');
    Route::get('/categories/{id}/edit',[CategoryController::class,'edit'])->middleware(['auth'])->name('catalog.categories.edit');
    Route::post('/storecategory',[CategoryController::class,'store'])->middleware(['auth'])->name('catalog.categories.store');
    Route::resource('categorias', CategoryController::class)->middleware(['auth'])->names('catalog.categories')->except(['destroy']);

    //DIVISION
    Route::get('/divisiones',[DivisionController::class,'index'])->middleware(['auth'])->name('catalog.div.index');
    Route::get('/divisiones/get-division-all', [DivisionController::class, 'getGeneralDivision'])->middleware(['auth'])->name('catalog.div.get'); // GET BRANDS
    Route::get('/divisiones/delete/{id}',[DivisionController::class,'delete'])->middleware(['auth'])->name('catalog.div.delete');
    Route::get('/divisiones/{id}/edit',[DivisionController::class,'edit'])->middleware(['auth'])->name('catalog.div.edit');
    Route::post('/storedivision',[DivisionController::class,'store'])->middleware(['auth'])->name('catalog.div.store');
    Route::resource('divisiones', DivisionController::class)->middleware(['auth'])->names('catalog.div')->except(['destroy']);

    //PROVIDER
    Route::get('/proveedores',[ProviderController::class,'index'])->middleware(['auth'])->name('catalog.provider.index');
    Route::get('/providers/get-provider-all', [ProviderController::class, 'getGeneralProviders'])->middleware(['auth'])->name('catalog.provider.get'); // GET PROVIDER
    // Route::get('/providers/delete/{id}',[CatalogController::class,'deleteProvider'])->middleware(['auth'])->name('catalog.destroyprovider');
    Route::post('/storeprovider',[ProviderController::class,'store'])->middleware(['auth'])->name('catalog.provider.store');
    Route::resource('proveedores', ProviderController::class)->middleware(['auth'])->names('catalog.provider')->except(['destroy']);

    //COMPANY CELL PHONE
    Route::get('/companias-de-recargas',[CompanycellphoneController::class,'index'])->middleware(['auth'])->name('catalog.cellphone.index');
    Route::get('/companycellphone/get-cellphone-all', [CompanycellphoneController::class, 'getGeneralCompany'])->middleware(['auth'])->name('catalog.cellphone.get'); // GET PROVIDER
    Route::get('/cellphone/delete/{id}',[CompanycellphoneController::class,'delete'])->middleware(['auth'])->name('catalog.cellphone.delete');
    Route::get('/cellphone/{id}/edit',[CompanycellphoneController::class,'edit'])->middleware(['auth'])->name('catalog.cellphone.edit');
    Route::post('/storecellphone',[CompanycellphoneController::class,'store'])->middleware(['auth'])->name('catalog.cellphone.store');
    Route::resource('companias-de-recargas', CompanycellphoneController::class)->middleware(['auth'])->names('catalog.cellphone')->except(['destroy']);

    //COMPANY SERVICES
    Route::get('/companias-de-servicios',[CompanyserviceController::class,'index'])->middleware(['auth'])->name('catalog.service.index');
    Route::get('/companyservice/get-cellphone-all', [CompanyserviceController::class, 'getGeneralCompany'])->middleware(['auth'])->name('catalog.service.get'); // GET PROVIDER
    Route::get('/service/delete/{id}',[CompanyserviceController::class,'delete'])->middleware(['auth'])->name('catalog.service.delete');
    Route::get('/service/{id}/edit',[CompanyserviceController::class,'edit'])->middleware(['auth'])->name('catalog.service.edit');
    Route::post('/storeservice',[CompanyserviceController::class,'store'])->middleware(['auth'])->name('catalog.service.store');
    Route::resource('companias-de-servicios', CompanyserviceController::class)->middleware(['auth'])->names('catalog.service')->except(['destroy']);








    // Route::resource('catalog', CatalogController::class)->middleware(['auth'])->names('catalog')->except(['destroy']);

});
