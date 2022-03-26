<?php

namespace App\Http\Controllers\API\Superadmin;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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

    public function getEmployee(Request $request) {

    }

}
