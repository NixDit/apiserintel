<?php

namespace App\Http\Controllers\API\Superadmin;

use App\Http\Resources\ClientResource;
use App\Http\Resources\UserResource;
use App\Models\Sale;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Throwable;

class SuperadminController extends Controller
{

    public function getEmployees(): JsonResponse
    {

        try {

            $employees = User::role('employee')->get();
            $data = UserResource::collection( $employees );

            return response()->json([
                'ok'        => true,
                'employees' => $data,
            ]);
        } catch (Throwable $th) {
            return response()->json([
                'ok'        => false,
                'employees' => [],
            ]);
        }

    }

    public function getClients(): JsonResponse {
        try {

            $employees  = User::role('client')->get();
            $data       = ClientResource::collection( $employees );
            return response()->json([
                'ok' => true,
                'clients' => $data
            ]);

        } catch (Throwable $th) {
            return response()->json([
                'ok'        => false,
                'clients' => [],
            ], 400);
        }

    }

    public function storeClient(Request $request): JsonResponse {
        $request->validate([
            'name'          => 'required|string|max:255',
            'last_name'     => 'required|string|max:255',
            'email'         => 'required|unique:users|email',
            'phone'         => 'required|max:255',
            'address'       => 'required',
            'business_name' => 'required',
        ]);

        try {
            //BEGIN:: Create a client
            $client = User::create([
                'name'      => $request->name,
                'last_name' => $request->last_name,
                'email'     => $request->email,
                'password'  => Hash::make('Cliente@2022'),
            ]);

            $client->assignRole('client');

            $client_code = 'SC-' . (str_pad( $client->id, 10, '0', STR_PAD_LEFT));

            $client->clientInformation()->create([
                'business_name' => $request->business_name,
                'code'          => $client_code,
                'phone'         => $request->phone,
                'address'       => $request->address,
            ]);

            return response()->json([
                'ok'        => true,
                'message'   => 'Cliente creado correctamente',
            ], 201 );

            //END:: Create a client
        } catch (Throwable $th) {
            return response()->json([
                'ok' => false,
                'message' => 'Error al crear el cliente',
            ], 400);
        }
    }

    public function storeEmployee(Request $request): JsonResponse {

        $request->validate([
            'name'      => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email'     => 'required|unique:users|email',
        ]);

        try {

            $user = User::create([
                'name'      => $request->name,
                'last_name' => $request->last_name,
                'email'     => $request->email,
                'password'  => Hash::make('Empleado2022'),
            ]);

            $user->assignRole('employee');

            return response()->json([
                'ok'        => true,
                'message'   => 'Empleado creado correctamente',
            ], 201 );

        } catch (Throwable $th) {
            return response()->json([
                'ok'        => false,
                'message'   => "Ocurrio un error durante el proceso\nError: {$th->getMessage()}"
            ], 400 );
        }

    }

    public function getSales( Request $request) {

        $sales = $this->salesQuery($request);
        return $sales;

    }

    private function salesQuery(Request $request) {
        $query = Sale::query();

        if( $request->from && $request->to ) {
            $from = Carbon::createFromFormat('d/m/Y', $request->from);
            $to = Carbon::createFromFormat('d/m/Y', $request->to);

            $query->whereBetween('created_at',[$from->format('Y-m-d 0:0:0'), $to->format('Y-m-d 23:59:59')] );
            $query->when(request('type') != 0, function ($q) {
                return $q->where('type', request('type'));
            });
            return $query->orderBy('client_id')->get();
        }

        $query->whereDate('created_at', Carbon::today());
        $query->when(request('type') != 0, function ($q) {
            return $q->where('type', request('type'));
        });

        return $query->orderBy('client_id')->get();
    }

}
