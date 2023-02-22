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

class ProviderController extends Controller
{


    public function index(){
        return view('serintel.catalog.providers');
    }

    //STORE PROVIDER
    public function store(Request $request)
    {
        $event = User::create([
            'name'      =>$request->name_provider,
            'last_name' =>$request->last_name_provider,
            'email'     =>$request->email_provider,
            'password'  => Hash::make('Provider2023'),
        ]);
        $event->assignRole('provider');

        $event->providers()->create([
            'razon_social' => $request->razon_provider,
            'rfc'          => $request->rfc_provider,
            'phone'         => $request->phone_provider,
            'address'       => $request->address_provider,
        ]);

        event(new Registered($event));
        Session::flash('alert',[ // Message for Swal general alert
            'type'    => 'success',
            'message' => 'Nuevo proveedor registrado'
        ]);
        return back();
    }


    public function getGeneralProviders() {
        $request = request();
        $provider   = Provider::with(['provider']);
        return $provider->get();
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
