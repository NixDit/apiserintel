<?php

use App\Http\Controllers\API\Superadmin\SuperadminController;
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
Route::post('/token/delete', [AuthController::class, 'deleteDevice'])->name('api.token.destroy');

//BEGIN:GUEST ROUTES
Route::get('/get-products', [ProductsController::class, 'getProducts'])->name('api.products.get');
//END:GUEST ROUTES

Route::get('/sales/get', [SuperadminController::class, 'getSales'])->name('api.sales-superadmin.get');

// ROUTES PROTECTED BY AUTH:SANCTUM
Route::group(['middleware' => 'auth:sanctum'], function() {

    //BEGIN:: General routes
    Route::get('/employees/get-all', [SuperadminController::class, 'getEmployees'])->name('api.employees.get');
    Route::get('/clients/get-all', [SuperadminController::class, 'getClients'])->name('api.clients.get');

    //BEGIN:: General routes
    Route::get('/token-renew', [AuthController::class, 'tokenRenew'])->name('api.token.renew');
    Route::post('/user/update', [AuthController::class, 'update'])->name('api.user.update');
    Route::get('/token-renew', [AuthController::class, 'tokenRenew'])->name('api.token.renew');
    //END:: General routes

    //BEGIN:: Product Routes
    Route::get('/categories-and-brands/get', [ProductsController::class, 'getCategoriesAndBrands'])->name('api.categories.update');
    Route::post('/product/store', [ProductsController::class, 'store'])->name('api.product.store');
    //END:: Product routes


    //BEGIN:: Client routes
    Route::post('/client', [ClientController::class, 'getClient'])->name('api.client.get');
    //END:: Client routes


    //BEGIN:: Sale routes
    Route::post('/sale', [SalesController::class, 'store'])->name('api.sales.store');
    Route::post('/send-fcm', [SalesController::class, 'sendFCM'])->name('api.sales.message');
    Route::post('/get-sales', [SalesController::class, 'getSales'])->name('api.sales.get');
    Route::get('/sales/download-report',[SalesController::class,'downloadExcelFromDates'])->name('api.sales.download');
    Route::get('/get-route', [SalesController::class, 'getRoute'])->name('api.sales.routes.get');

    Route::get('/get-ticket', [SalesController::class, 'getTicket'])->name('api.sales.getTicket');
    //END:: Sale routes

    //BEGIN:: Superadmin routes
    Route::post('/employees/store', [SuperadminController::class, 'storeEmployee'])->name('api.employee.store');
    Route::post('/clients/store', [SuperadminController::class, 'storeClient'])->name('api.client.store');
    Route::get('/clients/qr', [SuperadminController::class, 'getQrClients'])->name('api.client.getQr');
    //END:: Superadmin routes

});
