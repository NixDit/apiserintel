<?php

use App\Http\Controllers\User\UserController;


Route::group(['middleware' => ['role:superadmin']], function () {
    //
    Route::get('/users',[UserController::class,'index'])->middleware(['auth'])->name('index-user');
    Route::get('/user/get-all', [UserController::class, 'getUsers'])->middleware(['auth'])->name('users.get');
    Route::get('/user/delete/{id}', [UserController::class, 'delete'])->middleware(['auth'])->name('users.delete'); //TO: DELETE
    Route::get('/user/editar/{id}', [UserController::class, 'edit'])->middleware(['auth'])->name('users.edit'); //TO: EDIT

});
