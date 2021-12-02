<?php

namespace App\Http\Controllers\API\Sales;

use Carbon\Carbon;
use App\Models\Sale;
use App\Models\User;
use App\Models\Route;
use App\Models\ScanLog;
use App\Models\ProductSale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Resources\SaleCollection;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Notification;
use Kutia\Larafirebase\Facades\Larafirebase;
use App\Http\Resources\TicketProductsResource;
use App\Notifications\NewPurchaseNotification;
use App\Exports\EmployeeSalesReportExportSheet;
use PDF;

class SalesController extends Controller
{
    
    public function store( Request $request ) {

        // convert json to array
        $products = json_decode( $request->products, true);
        $employee_id = Auth::user()->id;
        $data = [];

        try {
            
            DB::transaction( function() use ( $products, $employee_id, $request) {

                $sale = Sale::create([
                    'employee_id'   => $employee_id,
                    'client_id'     => $request->client_id,
                    'subtotal'      => $request->subtotal,
                    'total'         => $request->total,
                    'type'          => $request->type
                ]);

                $sale->folio = 'S-' . (str_pad( $sale->id, 10, '0', STR_PAD_LEFT));
                $sale->save();
                
                
                foreach ($products as $key => $product) {

                    $product_for_sale = ProductSale::create([
                        'product_id'    => isset( $product["product"] ) ? $product["product"]["id"] : 1,
                        'sale_id'       => $sale->id,
                        'quantity'      => $product["quantity"],
                        'subtotal'      => $product["subtotal"],
                        'total'         => $product["total"]
                    ]);

                }

                
                $this->notificateAdmins( $sale );

            });

            $latest_sale = Sale::latest()->first();;
            $data = new TicketProductsResource( $latest_sale );

            return response()->json([
                'ok'            => true,
                'ticket'        => $data,
                'message'       => 'Venta realizada correctamente',
            ], 201);

        } catch (\Throwable $th) {

            return response()->json([
                'ok'        => false,
                'message'   => $th->getMessage(),
            ], 400);

        }

    }

    public function getRoute() {

        $dayOfTheWeek = Carbon::now('America/Monterrey')->dayOfWeek;

        $route = Route::where('day', $dayOfTheWeek )
                    ->where('employee_id', Auth::id() )
                    ->with(['clients:id,name,last_name,email,created_at', 'clients.clientInformation'])
                    ->first();                 

        if( $route ) {


            $logs = ScanLog::where('route_id', $route->id )
                    ->whereDate('created_at', Carbon::today())
                    ->with('client.clientInformation')
                    ->get()
                    ->pluck('client.clientInformation.code');
                    
            $route->logs = $logs;
            
            return response()->json([
                'ok'        => true,
                'route'     => $route,
                'message'   => 'Ruta encontrada'
            ]);
        }else {
            return response()->json([
                'ok'        => false,
                'route'     => [],
                'message'   => 'No hay una ruta designada para el dia de hoy'
            ], 400 );
        }

    }

    public function getSales( Request $request ) {

        $user = Auth::user();
        
        if( $request->from_date == null && $request->to_date == null ) {
            $sales = $user->sales()->whereDate('created_at', Carbon::today() )->get();
        } else {

            $from = Carbon::createFromFormat('d/m/Y', $request->from_date);
            $to = Carbon::createFromFormat('d/m/Y', $request->to_date);

            $sales = $user->sales()->whereBetween('created_at',[$from->format('Y-m-d 0:0:0'), $to->format('Y-m-d 23:59:59')] )->get();
        }

        $data = SaleCollection::collection( $sales );

        return response()->json([
            'ok'        => true,
            'sales'     => $data,
            'message'   => 'Ventas encontradas'
        ], 200 );
        
    }

    public function downloadExcelFromDates( ) {

        $user = Auth::user();

        if( request()->from_date == null && request()->to_date == null ) {
            $today = Carbon::today();
            $today_format = $today->format('d-m-Y');
            $sales = $user->sales()->whereDate('created_at', $today )->get();
            $excel_name = "VENTAS_REALIZADAS_POR_{$user->name}_{$today_format}.xlsx";
        } else {

            $from = Carbon::createFromFormat('d/m/Y', request()->from_date);
            $to = Carbon::createFromFormat('d/m/Y', request()->to_date);

            $from_format    = $from->format('d-m-Y');
            $to_format      = $to->format('d-m-Y');

            $sales = $user->sales()->whereBetween('created_at',[$from->format('Y-m-d 0:0:0'), $to->format('Y-m-d 23:59:59')] )->get();

            // dd( $sales );
            $excel_name = "VENTAS_REALIZADAS_POR_{$user->name}_{$from_format}_A_{$to_format}.xlsx";
        }


        // dd($sales);
        return Excel::download(new EmployeeSalesReportExportSheet($sales->chunk(50)), $excel_name );

    }


    public function notificateAdmins( $sale ) {

        $users = User::role('superadmin')->get();

        Notification::send($users, new NewPurchaseNotification($sale));

    }
    
    public function getTicket() {

        $latest_sale = Sale::latest()->first();;
        $data = new TicketProductsResource( $latest_sale );

        return response()->json([
            'ok'            => true,
            'ticket'        => $data,
            'message'       => 'Venta realizada correctamente',
        ], 201);

    }

    public function downloadTicket( $ticketId ) {

        $sale = Sale::findOrFail( $ticketId );
        view()->share('sale', $sale);
        $pdf_doc = PDF::loadView('sales.ticket', compact('sale'))->setOptions(['defaultFont' => 'sans-serif']);

        return $pdf_doc->download('pdf.pdf');

    }

}
