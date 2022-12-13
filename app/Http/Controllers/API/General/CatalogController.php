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


    public function deleteDivision( $id ) {
        try {
            $deletedDivi     = Division::findOrFail($id)->delete();
            if( $deletedDivi ) {
                $title  = 'Eliminado';
                $msj    = 'El rol ha sido eliminado correctamente';
                $type   = 'success';
            } else {
                $title  = 'Error';
                $msj    = 'Ocurrio un error durante el proceso, contacte al equipo de sistemas o intentelo más tarde';
                $type   = 'error';
            }
            return response()->json([
                'title'     => $title,
                'message'   => $msj,
                'type'      => $type
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'title'     => 'Error',
                'message'   => "Ocurrio un error: " . $th->getMessage(),
                'type'      => 'error'
            ]);
        }

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
