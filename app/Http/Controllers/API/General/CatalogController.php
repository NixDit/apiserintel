<?php

namespace App\Http\Controllers\API\General;

use App\Models\Line;
use App\Models\Brand;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Session;

class CatalogController extends Controller
{
    public function index(){
        return view('serintel.catalog.index');
    }

    public function brands(){
        return view('serintel.catalog.brands');
    }

    public function categories(){
        return view('serintel.catalog.categories');
    }


    public function create()
    {
        $data               = (object)[];
        $data->category     = Category::all();
        $data->brand        = Brand::all();
        $data->line         = Line::all();
        return view('serintel.product.create', compact('data'));
    }



    public function getGeneralProducts() {
        $request = request();
        $products   = Product::with(['category','brand','line'])
        ->whereNull('deleted_at');
        return $products->get();
    }







}
