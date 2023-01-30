<?php

namespace App\Http\Controllers\API\General;

use App\Models\Line;
use App\Models\Brand;
use App\Models\Product;
use App\Models\Category;
use App\Models\Division;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Session;

class ProductsController extends Controller
{
    public function index(){
        $data               = (object)[];
        $data->category     = Category::all();
        $data->brand        = Brand::all();
        $data->line         = Line::all();
        $data->division     = Division::all();
        // return view('serintel.product.index');
        return view('serintel.product.index', compact('data'));
    }

    public function create()
    {
        $data               = (object)[];
        $data->category     = Category::all();
        $data->brand        = Brand::all();
        $data->line         = Line::all();
        $data->division     = Division::all();
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
            'division_id' =>$request->division_id,
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

    public function edit($id){
        $error   = false;
        $message = null;
        $render  = null;
        try {
            $product = Product::find($id);
            if($product){
                $data             = (object)[];
                $data->product    = $product;
                $data->categories = Category::select('id','name')->get();
                $data->brands     = Brand::select('id','name')->get();
                $data->lines      = Line::select('id','name')->get();
                $data->divisions  = Division::select('id','name')->get();
                $render = view('serintel.product.modals.update_product',compact('data'))->render();
            } else {
                $error   = false;
                $message = 'Producto no encontrado';
            }
        } catch (\Throwable $th) {
            $error   = false;
            $message = "Ocurrió un error durante el proceso: {$th->getMessage()}";
        }

        return response()->json([
            'error'   => $error,
            'message' => $message,
            'render'  => $render
        ]);
    }

    public function update(Request $request){
        $type_message = false;
        $message      = null;
        try {
            $product = Product::find($request->id);
            if($product){
                $updated = $product->update($request->all());
                if($updated) {
                    $type_message = 'success';
                    $message      = 'Producto editado correctamente';
                } else {
                    $type_message = 'warning';
                    $message      = 'El producto no fue editado, intente nuevamente';
                }
            } else {
                $type_message = 'error';
                $message      = 'Producto no encontrado';
            }
        } catch (\Throwable $th) {
            $type_message = 'error';
            $message      = "Ocurrio un error durante el proceso: {$th->getMessage()}";
        }

        Session::flash('alert',[ // Message alert
            'type'    => $type_message,
            'message' => $message
        ]);

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

    public function destroy($id){
        $error   = false;
        $message = null;
        try {
            $product = Product::find($id);
            if($product){
                $deleted = $product->delete();
                if($deleted){
                    $message = 'Producto eliminado correctamente';
                } else {
                    $error   = true;
                    $message = 'El producto no pudo ser eliminado, intente nuevamente';
                }
            } else {
                $error   = true;
                $message = 'Producto no encontrado';
            }
        } catch (\Throwable $th) {
            $error   = true;
            $message = "Ocurrió un error durante el proceso: {$th->getMessage()}";
        }

        return response()->json([
            'error'   => $error,
            'message' => $message
        ]);
    }

    public function searchProduct(){
        $error    = false;
        $message  = null;
        $request  = request();
        $products = [];
        try {
            $search = $request->search;
            if(!is_null($search) && $search != ''){
                $products = Product::where('name','LIKE',"%{$search}%")
                                    ->orWhere('code','LIKE',"%{$search}%")
                                    ->orWhere('description','LIKE',"%{$search}%")
                                    ->get();
            }
        } catch (\Throwable $th) {
            $error   = false;
            $message = "Ocurrió un error: {$th->getMessage()}";
        }

        return response()->json([
            'error'    => $error,
            'message'  => $message,
            'products' => $products
        ]);
    }

}
