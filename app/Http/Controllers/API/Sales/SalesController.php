<?php

namespace App\Http\Controllers\API\Sales;

use App\Models\Sale;
use App\Models\ProductSale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class SalesController extends Controller
{
    
    public function store( Request $request ) {

        // convert json to array
        $products = json_decode( $request->products, true);
        $employee_id = Auth::user()->id;

        try {
            
            DB::transaction( function() use ( $products, $employee_id, $request) {

                $sale = Sale::create([
                    'employee_id'   => $employee_id,
                    'client_id'     => $request->client_id,
                    'subtotal'      => $request->subtotal,
                    'total'         => $request->total,
                ]);

                $sale->folio = 'S-' . (str_pad( $sale->id, 10, '0', STR_PAD_LEFT));
                $sale->save();
                
                
                foreach ($products as $key => $product) {

                    $product_for_sale = ProductSale::create([
                        'product_id'    => $product["product"]["id"],
                        'sale_id'       => $sale->id,
                        'quantity'      => $product["quantity"],
                        'subtotal'      => $product["subtotal"],
                        'total'         => $product["total"]
                    ]);

                }

            });

            return response()->json([
                'ok'            => true,
                'message'       => 'Venta realizada correctamente',
            ], 201);

        } catch (\Throwable $th) {

            return response()->json([
                'ok'        => false,
                'message'   => $th->getMessage(),
            ], 400);

        }

        

        

    }

}
