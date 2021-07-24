<?php

namespace App\Http\Controllers\API\General;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductsController extends Controller
{
    

    public function getProducts() {

        $categories = Category::with('products')->get();

        $categories->makeHidden([ 'created_at','deleted_at', 'updated_at']);

        if( $categories ) {

            return response()->json([
                'ok' => true,
                'categories' => $categories,
                'message' => 'Productos encontrados'
            ]);

        } else {
            return response()->json([
                'ok'        => false,
                'categories'  => [],
                'message'   => 'No hay productos registrados en el sistema'
            ]);
        }

    }


}
