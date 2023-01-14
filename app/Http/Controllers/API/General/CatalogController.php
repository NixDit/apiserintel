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

    public function divisiones(){
        return view('serintel.catalog.divisions');
    }

    public function providers(){
        return view('serintel.catalog.providers');
    }

    //STORE BRAND
    public function storebrand(Request $request)
    {
        $event = Brand::create([
            'name' =>$request->name_brand,
        ]);
        event(new Registered($event));
        Session::flash('alert',[ // Message for Swal general alert
            'type'    => 'success',
            'message' => 'Nueva marca registrada'
        ]);
        // return redirect()->route('view-products');
        return back();
    }

    //STORE DIVISION
    public function storedivision(Request $request)
    {
        $event = Division::create([
            'name' =>$request->name_division,
        ]);
        event(new Registered($event));
        Session::flash('alert',[ // Message for Swal general alert
            'type'    => 'success',
            'message' => 'Registro exitoso'
        ]);
        // return redirect()->route('view-products');
        return back();
    }


    public function getGeneralBrands() {
        return Brand::get();
    }

    public function getGeneralCategories() {
        return Category::get();
    }

    public function getGeneralDivision() {
        return Division::get();
    }

    public function getGeneralProviders() {
        $request = request();
        $provider   = Provider::with(['provider']);
        return $provider->get();
    }

    //Edit Division
    public function editDivision($id){
        $error   = false;
        $message = null;
        $render  = null;
        try {
            $division = Division::find($id);
            if($division){
                $data             = (object)[];
                $data->division    = $division;
                $render = view('serintel.catalog.modals.update_division',compact('data'))->render();
            } else {
                $error   = false;
                $message = 'Division no encontrado';
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

    //Update Division
    public function updateDivision(Request $request){
        $type_message = false;
        $message      = null;
        try {
            $division = Division::find($request->id);
            if($division){
                $updated = $division->update($request->all());
                if($updated) {
                    $type_message = 'success';
                    $message      = 'Division editado correctamente';
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

    //Delete Division
    public function deleteDivision( $id ) {
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
                $message = 'División no encontrado';
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

    //Delete Brand
    public function deleteBrand( $id ) {
        $error   = false;
        $message = null;
        try {
            $brand = Brand::find($id);
            if($brand){
                $deleted = $brand->delete();
                if($deleted){
                    $message = 'Marca eliminado correctamente';
                    $type   = 'success';
                } else {
                    $error   = true;
                    $message = 'Error pudo ser eliminado, intente nuevamente';
                }
            } else {
                $error   = true;
                $message = 'División no encontrado';
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

    //STORE PROVIDER
    public function storeProviderAdmin(Request $request)
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
            'message' => 'Nuevo cliente registrado'
        ]);
        return back();
    }







}
