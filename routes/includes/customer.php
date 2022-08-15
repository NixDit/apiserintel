<?php

use App\Http\Controllers\API\Client\ClientController;


Route::group(['middleware' => ['role:superadmin']], function () {
    //
    Route::get('/clients',[ClientController::class,'index'])->middleware(['auth'])->name('index-client');
    Route::get('/sales/get-all', [SalesController::class, 'getSales'])->middleware(['auth'])->name('sales.get');
    Route::get('/user/delete/{id}', [UserController::class, 'delete'])->middleware(['auth'])->name('users.delete'); //TO: DELETE
    Route::get('/user/editar/{id}', [UserController::class, 'edit'])->middleware(['auth'])->name('users.edit'); //TO: EDIT

});
