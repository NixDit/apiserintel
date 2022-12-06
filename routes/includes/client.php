<?php

use App\Http\Controllers\API\Client\ClientController;


Route::group(['middleware' => ['role:superadmin|employee']], function () {
    //
    Route::get('/clientes',[ClientController::class,'index'])->middleware(['auth'])->name('clients.index');
    Route::get('/clients/get-general-all', [ClientController::class, 'getGeneralClients'])->middleware(['auth'])->name('clients.get'); // TO: GENERAL

    Route::get('/user/delete/{id}', [ClientController::class, 'delete'])->middleware(['auth'])->name('clients.delete'); //TO: DELETE
    Route::get('/user/editar/{id}', [ClientController::class, 'edit'])->middleware(['auth'])->name('clients.edit'); //TO: EDIT
    Route::post('/storeclient',[ClientController::class,'storeClientAdmin'])->middleware(['auth'])->name('clients.storeclient');

    Route::get('/clientes/perfil/{id}', [ClientController::class, 'viewPerfil'])->middleware(['auth'])->name('clients.getPerfilClient'); //TO: VER PERFIL DEL USUARIO
    Route::resource('clientes', ClientController::class)->middleware(['auth'])->names('clients')->except(['destroy']);

});
