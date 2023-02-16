<?php

use App\Http\Controllers\API\Sales\SalesController;


Route::group(['middleware' => ['role:superadmin|employee']], function () {
    //
    Route::get('/sales',[SalesController::class,'index'])->middleware(['auth'])->name('sales.index');
    Route::get('/sales/get-all', [SalesController::class, 'getSales'])->middleware(['auth'])->name('sales.get'); // TO: EMPLOYEES
    Route::get('/sales/get-general-all', [SalesController::class, 'getGeneralSales'])->middleware(['auth'])->name('sales.get'); // TO: GENERAL
    Route::get('/sales/nueva-venta',[SalesController::class,'newSale'])->middleware(['auth'])->name('sales.new_sale');
    Route::get('/sales/download-ticket',[SalesController::class,'downloadTicketSale'])->middleware(['auth'])->name('sales.download-ticket');
    Route::get('/sales/get-ticket-view-data',[SalesController::class,'getTicketViewData'])->middleware(['auth'])->name('sales.get-ticket-view-data');
    Route::resource('ventas', SalesController::class)->middleware(['auth'])->names('sales')->except(['destroy']);

});
