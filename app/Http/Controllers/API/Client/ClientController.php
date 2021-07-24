<?php

namespace App\Http\Controllers\API\Client;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ClientController extends Controller
{
    



    public function getClient( $code ) {

        
        try {

            $client = User::whereHas('clientInformation', function( $clientInfo ) use ( $code ){
                        $clientInfo->where('code', $code);
                    })
                    ->with('clientInformation')
                    ->first();

            

            if( $client ) {

                $client->makeHidden(['roles', 'updated_at', 'email_verified_at']);
                $client->clientInformation->makeHidden(['id', 'user_id']);

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
}
