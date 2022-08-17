<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// GENERAL ROUTES
require __DIR__.'/includes/general.php';
// AUTH ROUTES
require __DIR__.'/auth.php';

// require __DIR__.'/user.php';

require __DIR__.'/includes/sales.php';

require __DIR__.'/includes/client.php';

require __DIR__.'/includes/product.php';
