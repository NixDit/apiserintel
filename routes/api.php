<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;

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


// ROUTES PROTECTED BY AUTH:SANCTUM
Route::group(['middleware' => 'auth:sanctum'], function() {

    Route::get('/token-renew', [AuthController::class, 'tokenRenew'])->name('api.token.renew');

});
