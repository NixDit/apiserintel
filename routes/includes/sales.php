<?php

use App\Http\Controllers\API\Sales\SalesController;


Route::group(['middleware' => ['role:superadmin']], function () {
    //
    Route::get('/sales',[SalesController::class,'index'])->middleware(['auth'])->name('index-sales');
    Route::get('/sales/get-all', [SalesController::class, 'getSales'])->middleware(['auth'])->name('sales.get');
    Route::get('/user/delete/{id}', [UserController::class, 'delete'])->middleware(['auth'])->name('users.delete'); //TO: DELETE
    Route::get('/user/editar/{id}', [UserController::class, 'edit'])->middleware(['auth'])->name('users.edit'); //TO: EDIT

});
