<?php

namespace App\Http\Controllers\API\Client;

use Carbon\Carbon;
use App\Models\User;
use App\Models\ScanLog;
use Illuminate\Http\Request;
use App\Models\ClientInformation;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\SaleCollection;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Session;
use App\Http\Resources\PrepaidPurchasesCollection;

class ClientController extends Controller
{
    public function index(){
        $data        = (object)[];
        $data->users = $this->getGeneralClients();
        return view('serintel.client.index',compact('data'));
    }

    //STORE CLIENT
    public function storeClientAdmin(Request $request)
    {
        $event = User::create([
            'name'      =>$request->name_client,
            'last_name' =>$request->last_name_client,
            'email'     =>$request->email_client,
            'password'  => Hash::make('Cliente2022'),
        ]);
        $event->assignRole('client');

        $client_code = 'SC-' . (str_pad( $event->id, 10, '0', STR_PAD_LEFT));

        $event->clientInformation()->create([
            'business_name' => $request->business_client,
            'code'          => $client_code,
            'phone'         => $request->phone_client,
            'address'       => $request->address_client,
        ]);

        event(new Registered($event));
        Session::flash('alert',[ // Message for Swal general alert
            'type'    => 'success',
            'message' => 'Nuevo cliente registrado'
        ]);
        return back();
    }

    public function getClient( Request $request ) {

        $code = !$request->isManual ? $request->code : 'SC-' . (str_pad( $request->code, 10, '0', STR_PAD_LEFT));

        try {

            $client = User::whereHas('clientInformation', function( $clientInfo ) use ( $code ){
                        $clientInfo->where('code', $code);
                    })
                    ->with('clientInformation')
                    ->with('debts')
                    ->first();

            if( $client ) {
                $client->credit = PrepaidPurchasesCollection::collection( $client->debts );
                $client->makeHidden(['roles', 'updated_at','debts' ,'email_verified_at']);
                $client->clientInformation->makeHidden(['id', 'user_id']);

                $log = ScanLog::updateOrCreate([
                    'client_id'     => $client->id,
                    'employee_id'   => Auth::id(),
                    'route_id'      => $request->route,
                    'created_at'    => ScanLog::where('created_at', '>', DB::raw('CURDATE()'))->first()->created_at ?? null
                ],[
                    'latlng'        => $request->latlng,
                ]
                );

                return response()->json([
                    'ok'            => true,
                    'message'       => 'Cliente encontrado',
                    'client'        => $client
                ], 200);

            }else {
                return response()->json([
                    'ok'            => false,
                    'message'       => 'Lo sentimos, no se ha encontrado ningun cliente con el codigo proporcionado',
                    'client'       => []
                ], 400);
            }

        } catch (\Throwable $th) {

            return response()->json([
                'ok'        => false,
                'message'   => $th->getMessage(),
            ], 400);
        }

    }

    public function getGeneralClients() {
        $request = request();
        $clients   = ClientInformation::with(['customer']);
        return $clients->get();
    }

    public function viewPerfil( $id ) {
        $data         = (object)[];
        $user         = User::find($id);
        return view( 'serintel.client.perfil')->with([
            'user'      => $user,
            'data'      => $data
        ]);
    }
}
