<?php

namespace App\Http\Controllers\API\General;

use App\Models\Brand;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductsController extends Controller
{
    
    public function store( Request $request ) {

        try {
            
            $newProduct = Product::create( $request->all() );

            if( $newProduct ) {

                return response()->json([
                    'ok'        => true,
                    'message'   => 'El producto ha sido guardado correctamente'
                ], 201 );

            } else {
                return response()->json([
                    'ok'        => false,
                    'message'   => 'Ocurrio un error durante el proceso, intentelo nuevamente'
                ], 400 );
            }

        } catch (\Throwable $th) {

            return response()->json([
                'ok'        => false,
                'message'   => "Ocurrio un error durante el proceso\nError: {$th->getMessage()}"
            ], 400 );

        }

    }

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

    public function getCategoriesAndBrands() {
        
        try {
            
            $categories = Category::select(['id', 'name'])->get();
            $brands     = Brand::all();
            $brands->makeHidden('image');

            return response()->json([
                'ok' => true,
                'categories'    => $categories,
                'brands'        => $brands,
                'message'       => 'Categorias y marcas encontradas'
            ]);

        } catch (\Throwable $th) {
            return response()->json([
                'ok'        => false,
                'message'   => "Ocurrio un error durante el proceso\n{$th->getMessage()}"
            ]);
        }

    }


}
