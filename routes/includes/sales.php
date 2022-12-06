<?php

use App\Http\Controllers\API\Sales\SalesController;


Route::group(['middleware' => ['role:superadmin|employee']], function () {
    //
    Route::get('/sales',[SalesController::class,'index'])->middleware(['auth'])->name('sales.index');
    Route::get('/sales/get-all', [SalesController::class, 'getSales'])->middleware(['auth'])->name('sales.get'); // TO: EMPLOYEES
    Route::get('/sales/get-general-all', [SalesController::class, 'getGeneralSales'])->middleware(['auth'])->name('sales.get'); // TO: GENERAL
    Route::resource('ventas', SalesController::class)->middleware(['auth'])->names('sales')->except(['destroy']);

});
