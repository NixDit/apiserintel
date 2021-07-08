<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    



    public function login( Request $request ) {

        $fields = $request->validate([
            'email'     => 'required|email',
            'password'  => 'required|string',
        ]);

        //CHECK IF EMAIL IS REGISTERED IN DB
        $user = User::where('email', $fields['email'])->first();

        if( !$user || !Hash::check( $fields['password'], $user->password ) ) {

            return response()->json([
                'ok'        => false,
                'message'   => 'Las credenciales que proporciono no coinciden, revise e intentelo nuevamente',
            ], 401);

        }

        $token = $user->createToken('authtoken')->plainTextToken;
        //Hide Unnecesary Fields in Role
        $user->roles->makeHidden(['guard_name', 'created_at', 'updated_at', 'pivot']);
        //Hide unnecesary user fields
        $user->makeHidden(['deleted_at', 'created_at', 'updated_at', 'email_verified_at']);

        return response()->json([
            'ok'        => true,
            'message'   => 'Bienvenido',
            'user'      => $user,
            'token'     => $token,
        ], 200);

    }

    public function tokenRenew() {


        $user = Auth::user();

        $token = $user->createToken('authtoken')->plainTextToken;

        return response()->json([
            'ok'        => true,
            'message'   => 'Token actualizado correctamente',
            'user'      => $user,
            'token'     => $token,
        ], 200);


    }
}
