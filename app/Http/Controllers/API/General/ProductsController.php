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

class ProductsController extends Controller
{
    public function index(){
        return view('serintel.product.index');
    }

    public function create()
    {
        $data               = (object)[];
        $data->category     = Category::all();
        $data->brand        = Brand::all();
        $data->line         = Line::all();
        return view('serintel.product.create', compact('data'));
    }

    public function storeproduct(Request $request)
    {

        $event = Product::create([
            'name' =>$request->name,
            'supplier_code' =>$request->supplier_code,
            'code' =>$request->code,
            'description' =>$request->description,
            'cost' =>$request->cost,
            'retail_price' =>$request->retail_price,
            'wholesale_price' =>$request->wholesale_price,
            'special_price' =>$request->special_price,
            'super_special_price' =>$request->super_special_price,
            'brand_id' =>$request->brand_id,
            'category_id' =>$request->category_id,
            'line_id' =>$request->line_id
        ]);
        // dd($event);

        event(new Registered($event));

        Session::flash('alert',[ // Message for Swal general alert
            'type'    => 'success',
            'message' => 'El producto ha sido agregado correctamente'
        ]);
        // return redirect()->route('view-products');
        return back();
    }

    public function getGeneralProducts() {
        $request = request();
        $products   = Product::with(['category','brand','line'])
        ->whereNull('deleted_at');
        return $products->get();
    }

    public function store( Request $request ): JsonResponse
    {

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

    public function getProducts(): JsonResponse
    {

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

    public function getCategoriesAndBrands(): JsonResponse
    {

        try {

            $categories = Category::select(['id', 'name'])->get();
            $brands     = Brand::all();
            $lines      = Line::select('id','name')->get();

            $brands->makeHidden('image');

            return response()->json([
                'ok' => true,
                'categories'    => $categories,
                'brands'        => $brands,
                'lines'         => $lines,
                'message'       => 'Lineas, Categorias y Marcas encontradas'
            ]);

        } catch (\Throwable $th) {
            return response()->json([
                'ok'        => false,
                'message'   => "Ocurrio un error durante el proceso\n{$th->getMessage()}"
            ]);
        }

    }



}
