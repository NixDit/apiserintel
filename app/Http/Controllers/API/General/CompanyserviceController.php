<?php

namespace App\Http\Controllers\API\General;

use Illuminate\Http\Request;
use App\Models\CompanyService;
use App\Models\CompanyCellphone;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Session;

class CompanyserviceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('serintel.catalog.service');
    }


    public function getGeneralCompany() {
        return CompanyService::get();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $event = CompanyService::create([
            'name' =>$request->name_company_service,
        ]);
        event(new Registered($event));
        Session::flash('alert',[ // Message for Swal general alert
            'type'    => 'success',
            'message' => 'Nueva compañía de servicio registrada'
        ]);
        // return redirect()->route('view-products');
        return back();
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id){
        $error   = false;
        $message = null;
        $render  = null;
        try {
            $company = CompanyService::find($id);
            if($company){
                $data             = (object)[];
                $data->company    = $company;
                $render = view('serintel.catalog.modals.update_company_service',compact('data'))->render();
            } else {
                $error   = false;
                $message = 'Compania no encontrado';
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

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request){
        $type_message = false;
        $message      = null;
        try {
            $company = CompanyService::find($request->id);
            if($company){
                $updated = $company->update($request->all());
                if($updated) {
                    $type_message = 'success';
                    $message      = 'Compañía editado correctamente';
                } else {
                    $type_message = 'warning';
                    $message      = 'La compañía no fue editado, intente nuevamente';
                }
            } else {
                $type_message = 'error';
                $message      = 'Compañía no encontrado';
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    //Delete Brand
    public function delete( $id ) {
        $error   = false;
        $message = null;
        try {
            $company = CompanyService::find($id);
            if($company){
                $deleted = $company->delete();
                if($deleted){
                    $message = 'Compañía eliminado correctamente';
                    $type   = 'success';
                } else {
                    $error   = true;
                    $message = 'Error pudo ser eliminado, intente nuevamente';
                }
            } else {
                $error   = true;
                $message = 'Conpania no encontrado';
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
}
