<?php

namespace App\Http\Controllers\API\General;

use App\Models\Line;
use App\Models\User;
use App\Models\Brand;
use App\Models\Product;
use App\Models\Category;
use App\Models\Division;
use App\Models\Provider;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Session;

class CategoryController extends Controller
{


    public function index(){
        return view('serintel.catalog.categories');
    }

    //STORE BRAND
    public function store(Request $request)
    {
        $event = Category::create([
            'name' =>$request->name_category,
        ]);
        event(new Registered($event));
        Session::flash('alert',[ // Message for Swal general alert
            'type'    => 'success',
            'message' => 'Nueva categoria registrada'
        ]);
        // return redirect()->route('view-products');
        return back();
    }


    public function getGeneralCategories() {
        return Category::get();
    }

    //Edit Brand
    public function edit($id){
        $error   = false;
        $message = null;
        $render  = null;
        try {
            $category = Category::find($id);
            if($category){
                $data             = (object)[];
                $data->category   = $category;
                $render = view('serintel.catalog.modals.update_category',compact('data'))->render();
            } else {
                $error   = false;
                $message = 'Categoría no encontrado';
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
        // return view( 'serintel.product.modals.update_product' )->with('division', Division::find($id));
    }

    //Update Brand
    public function update(Request $request){
        $type_message = false;
        $message      = null;
        try {
            $category = Category::find($request->id);
            if($category){
                $updated = $category->update($request->all());
                if($updated) {
                    $type_message = 'success';
                    $message      = 'Categoría editado correctamente';
                } else {
                    $type_message = 'warning';
                    $message      = 'La categoria no fue editado, intente nuevamente';
                }
            } else {
                $type_message = 'error';
                $message      = 'Categoría no encontrado';
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




    //Delete Brand
    public function delete( $id ) {
        $error   = false;
        $message = null;
        try {
            $category = Category::find($id);
            if($category){
                $deleted = $category->delete();
                if($deleted){
                    $message = 'Categoría eliminado correctamente';
                    $type   = 'success';
                } else {
                    $error   = true;
                    $message = 'Error pudo ser eliminado, intente nuevamente';
                }
            } else {
                $error   = true;
                $message = 'Categoría no encontrado';
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


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

}
