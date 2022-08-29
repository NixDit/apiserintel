<?php

use App\Http\Controllers\API\Superadmin\SuperadminController;


Route::group(['middleware' => ['role:superadmin']], function () {
    //
    Route::get('/users',[SuperadminController::class,'index'])->middleware(['auth'])->name('index-user');
    Route::get('/user/get-general-all', [SuperadminController::class, 'getGeneralUser'])->middleware(['auth'])->name('users.get');
    Route::get('/user/delete/{id}', [UserController::class, 'delete'])->middleware(['auth'])->name('users.delete'); //TO: DELETE
    Route::get('/user/editar/{id}', [UserController::class, 'edit'])->middleware(['auth'])->name('users.edit'); //TO: EDIT

});
