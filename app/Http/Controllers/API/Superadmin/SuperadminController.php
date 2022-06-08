<?php

namespace App\Http\Controllers\API\Superadmin;

use App\Http\Resources\ClientResource;
use App\Http\Resources\UserResource;
use App\Models\User;
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

}
