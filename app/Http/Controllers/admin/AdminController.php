<?php

namespace App\Http\Controllers\admin;

use App\Models\Sale;
use App\Models\User;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\ClientInformation;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function dashboard(){
        $data        = (object)[];
        $data->client  = ClientInformation::get();
        $data->sale  = Sale::get();
        $data->product  = Product::get();
        return view('administrator.dashboard',compact('data'));
    }
}
