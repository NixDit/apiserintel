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

class DivisionController extends Controller
{


    public function index(){
        return view('serintel.catalog.divisions');
    }

    //STORE BRAND
    public function store(Request $request)
    {
        $event = Division::create([
            'name' =>$request->name_division,
        ]);
        event(new Registered($event));
        Session::flash('alert',[ // Message for Swal general alert
            'type'    => 'success',
            'message' => 'Nueva división o línea registrada'
        ]);
        // return redirect()->route('view-products');
        return back();
    }


    public function getGeneralDivision() {
        return Division::get();
    }

    //Edit Brand
    public function edit($id){
        $error   = false;
        $message = null;
        $render  = null;
        try {
            $division = Division::find($id);
            if($division){
                $data             = (object)[];
                $data->division   = $division;
                $render = view('serintel.catalog.modals.update_division',compact('data'))->render();
            } else {
                $error   = false;
                $message = 'División no encontrado';
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
            $division = Division::find($request->id);
            if($division){
                $updated = $division->update($request->all());
                if($updated) {
                    $type_message = 'success';
                    $message      = 'División editado correctamente';
                } else {
                    $type_message = 'warning';
                    $message      = 'La division no fue editado, intente nuevamente';
                }
            } else {
                $type_message = 'error';
                $message      = 'Division no encontrado';
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
            $division = Division::find($id);
            if($division){
                $deleted = $division->delete();
                if($deleted){
                    $message = 'División eliminado correctamente';
                    $type   = 'success';
                } else {
                    $error   = true;
                    $message = 'Error pudo ser eliminado, intente nuevamente';
                }
            } else {
                $error   = true;
                $message = 'Division no encontrado';
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
