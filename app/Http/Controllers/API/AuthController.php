<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use App\Models\Device;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    


    // BEGIN:: Signin function
    public function login( Request $request ) {

        $fields = $request->validate([
            'email'     => 'required|email',
            'password'  => 'required|string',
        ]);

        //CHECK IF EMAIL IS REGISTERED IN DB
        $user = User::where('email', $fields['email'])->with('roles')->first();

        if( !$user || !Hash::check( $fields['password'], $user->password ) ) {

            return response()->json([
                'ok'        => false,
                'message'   => 'Las credenciales que proporciono no coinciden, revise e intentelo nuevamente',
            ], 401);

        }

        $user->devices()->firstOrCreate(['token' => $request->token]);

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
    // END:: Signin function


    // BEGIN:: Signup function
    public function signup( Request $request ) {

        $fields = $request->validate([
            'name'      => 'required|string',
            'last_name' => 'required|string',
            'email'     => 'required|email|unique:users,email',
            'password'  => 'required|string|confirmed',
        ]);

        $user = User::create([
            'name'      => $fields['name'],
            'last_name' => $fields['last_name'],
            'email'     => $fields['email'],
            'password'  => Hash::make( $fields['password'] ),
        ]);

        $user->refresh();

        $user->assignRole('guest');

        $user->devices()->firstOrCreate(['token' => $request->token]);

        $token = $user->createToken('authtoken')->plainTextToken;

        //Hide Unnecesary Fields in Role
        $user->roles->makeHidden(['guard_name', 'created_at', 'updated_at', 'pivot']);
        //Hide unnecesary user fields
        $user->makeHidden(['deleted_at', 'created_at', 'updated_at', 'email_verified_at']);

        return response()->json([
            'ok'        => true,
            'message'   => 'Bienvenido ' . $user->name,
            'user'      => $user,
            'token'     => $token,
        ], 201);

    }
    // END: Signup function

    // BEGIN:: Update function
    public function update( Request $request ) {


        $fields = $request->validate([
            'id'            => 'required',
            'name'          => 'required|string',
            'last_name'     => 'required|string',
        ]);

        $user = User::find( $request->id );

        $user->name = $fields['name'];
        $user->last_name = $fields['last_name'];

        $user->save();
        
        if( $request->new_password != null && $request->password != null) {
            if( Hash::check( $request['password'], $user->password ) ) {
                $user->password = Hash::make($request->new_password);
                $user->save();
            } else {
                return response()->json([
                    'ok'        => false,
                    'message'   => 'No pudimos actualizar tu contraseña debido que a la contraña actual no coincide con la que proporcionaste',
                ], 401);
            }
        }

        $user->refresh();

        //Hide Unnecesary Fields in Role
        $user->roles->makeHidden(['guard_name', 'created_at', 'updated_at', 'pivot']);
        //Hide unnecesary user fields
        $user->makeHidden(['deleted_at', 'created_at', 'updated_at', 'email_verified_at']);

        return response()->json([
            'ok'        => true,
            'message'   => 'Datos actualizados correctamente ',
            'user'      => $user,
            'token'     => 'none',
        ], 201);

    }
    // END: Update function

    public function tokenRenew() {


        $user = Auth::user();
        $user->load('roles:id,name');
        $user->roles->makeHidden(['pivot']);

        $token = $user->createToken('authtoken')->plainTextToken;

        return response()->json([
            'ok'        => true,
            'message'   => 'Token actualizado correctamente',
            'user'      => $user,
            'token'     => $token,
        ], 200);


    }

    public function deleteDevice( Request $request ) {

        try {
            
            $token = Device::where( 'user_id' , Auth::user()->id )->where( 'token', $request->token )->delete();

            return response()->json([
                'ok'        => true,
                'message'   => 'Token eliminado correctamente',
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'ok'        => true,
                'message'   => "Ocurrio un error: " . $th->getMessage(),
            ], 401);
        }

    }
}
