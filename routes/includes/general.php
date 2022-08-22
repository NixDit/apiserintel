<?php

use App\Http\Controllers\admin\AdminController;

// Login route
Route::get('/', function () {
    return redirect()->route('login');
});
// Dashboard route
Route::get('/dashboard-app-serintel',[AdminController::class,'dashboard'])->middleware(['auth'])->name('dashboard.app');