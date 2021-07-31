<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\Sales\SalesController;
use App\Http\Controllers\API\Client\ClientController;
use App\Http\Controllers\API\General\ProductsController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// AUTHENTICATION ROUTES
Route::post('/signup', [AuthController::class, 'signup'])->name('api.user.create');
Route::post('/login', [AuthController::class, 'login'])->name('api.user.login');

//BEGIN:GUEST ROUTES
Route::get('/get-products', [ProductsController::class, 'getProducts'])->name('api.products.get');
//END:GUEST ROUTES

// ROUTES PROTECTED BY AUTH:SANCTUM
Route::group(['middleware' => 'auth:sanctum'], function() {

    //BEGIN:: General routes
    Route::get('/token-renew', [AuthController::class, 'tokenRenew'])->name('api.token.renew');
    //END:: General routes

    //BEGIN:: Client routes
    Route::get('/client/{code}', [ClientController::class, 'getClient'])->name('api.client.get');
    //END:: Client routes


    //BEGIN:: Sale routes
    Route::post('/sale', [SalesController::class, 'store'])->name('api.sales.store');
    //END:: Sale routes
});
