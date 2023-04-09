<?php

namespace App\Http\Controllers\API\Sales;

use Illuminate\Support\Facades\Log;
use PDF;
use Carbon\Carbon;
use App\Models\Sale;
use App\Models\User;
use App\Models\Route;
use App\Models\Credit;
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
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class SalesController extends Controller
{
    public function index(){
        return view('sales.index');
    }

    public function newSale(){
        return view('sales.new-sale');
    }

    public function store( Request $request ) {

        // convert json to array

        $products = json_decode( $request->products, true);
        $employee_id = Auth::user()->id;
        $data = [];

        try {

            DB::transaction( function() use ( $products, $employee_id, $request) {

                $sale = Sale::create([
                    'employee_id'   => $employee_id,
                    'client_id'     => ($request->client_id > 0) ? $request->client_id : User::where(['email' => 'clienteglobal@gmail.com'])->first()->id,
                    'subtotal'      => $request->subtotal,
                    'total'         => $request->total,
                    'type'          => $request->type,
                    'payment_method' => $request->payment_method
                ]);

                $sale->folio = 'SV-' . (str_pad( $sale->id, 10, '0', STR_PAD_LEFT));
                $sale->save();


                $productSaleCount = 0;      //Para saber si ya se guardo un pago de credito ya que para cada pago es necesario guardar un registro en la tabla
                $productSaleTotal = 0;     // product_sale que es pivote pero todos los pagos de credito tienen id 1, asi que al ser primario
                                            // no se pueden guardar mas de 2 productos con el mismo id en la tabla

                foreach ($products as $key => $product) {
                    if( isset($product["credit_id"]) ) {

                        $saleWithCredit = Sale::find($product["credit_id"]);
                        $credit = $saleWithCredit->credit;

                        $payment = $credit->payments()->create([
                            'quantity' => $product["total"]
                        ]);

                        $totalPaid = $credit->payments->sum('quantity');

                        if( $totalPaid >= $credit->total ) {
                            $credit->update([ 'status' => 1 ]);
                        }

                        //Para solo crear un solo registro con el total de los pagos de credito en la tabla product_sale
                        $productSaleCount++;
                        $productSaleTotal += $product["total"];


                    } else if( isset($product["isTotalPayment"])) {

                        //TODO:: Obtener los creditos del cliente y actualizarlos a pagado
                        $salesWithCredit = $sale->customer->debts;

                        $productSaleCount++;

                        foreach ($salesWithCredit as $key => $saleWithCredit) {

                            $credit = $saleWithCredit->credit;
                            $total =  $credit->total - $credit->payments->sum('quantity');

                            $payment = $credit->payments()->create([
                                'quantity' => $total
                            ]);

                            $productSaleTotal += $total;
                            $credit->update(['status' => 1 ]);
                        }


                    } else {
                        if(isset($product["recharge_data"])){
                            $product_for_sale = ProductSale::create([
                                'product_id'    => $product["product"]["id"],
                                'sale_id'       => $sale->id,
                                'quantity'      => $product["quantity"],
                                'subtotal'      => $product["subtotal"],
                                'total'         => $product["total"],
                                'is_recharge'   => $product["recharge_data"]["is_recharge"],
                                'phone'         => isset($product["recharge_data"]["phonenumber"]) ? $product["recharge_data"]["phonenumber"] : null,
                                'company_id'    => isset($product["recharge_data"]["company_id"]) ? $product["recharge_data"]["company_id"] : null
                            ]);
                        } else {
                            $product_for_sale = ProductSale::create([
                                'product_id'    => $product["product"]["id"],
                                'sale_id'       => $sale->id,
                                'quantity'      => $product["quantity"],
                                'subtotal'      => $product["subtotal"],
                                'total'         => $product["total"]
                            ]);
                        }
                    }


                    //Si es la ultima iteracion
                    if ($key === array_key_last($products)) {

                        //Si en la venta hubo por lo menos 1 abono de credito
                        if( $productSaleCount > 0 ) {
                            $productSale = ProductSale::create([
                                'product_id'    => 1,
                                'sale_id'       => $sale->id,
                                'quantity'      => $productSaleCount,
                                'subtotal'      => $productSaleTotal,
                                'total'         => $productSaleTotal
                            ]);
                        }

                    }


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
        $query = Sale::query();


        if( $request->from_date == null && $request->to_date == null ) {

            $query->where('employee_id', $user->id )->whereDate('created_at', Carbon::today());

            $query->when(request('type') != 0, function ($q) {
                return $q->where('type', request('type'));
            });

            $sales = $query->get();
        }else {

            $from = Carbon::createFromFormat('d/m/Y', $request->from_date);
            $to = Carbon::createFromFormat('d/m/Y', $request->to_date);

            $query->where('employee_id', $user->id )->whereBetween('created_at',[$from->format('Y-m-d 0:0:0'), $to->format('Y-m-d 23:59:59')] );

            $query->when(request('type') != 0, function ($q) {
                return $q->where('type', request('type'));
            });

            $sales = $query->get();

        }

        $data = SaleCollection::collection( $sales );

        return response()->json([
            'ok'        => true,
            'sales'     => $data,
            'message'   => 'Ventas encontradas'
        ], 200 );

    }

    public function getGeneralSales() {
        $request = request();
        $sales   = Sale::with(['customer','seller']);
        return $sales->get();
    }

    public function downloadExcelFromDates(): BinaryFileResponse
    {

        $user = Auth::user();
        $query = Sale::query();
        $filters = ['GENERALES', 'PREPAGO', 'PAGADO', 'POSTPAGO'];

        if( $user->hasRole('employee') )
            $query->where('employee_id', $user->id);

        $from = Carbon::createFromFormat('d/m/Y', request()->from_date);
        $to = Carbon::createFromFormat('d/m/Y', request()->to_date);

        $from_format    = $from->format('d-m-Y');
        $to_format      = $to->format('d-m-Y');

        $query->whereBetween('created_at',[$from->format('Y-m-d 0:0:0'), $to->format('Y-m-d 23:59:59')] );

        $query->when(request()->type != 0, function ($q) {
            return $q->where('type', request()->type);
        });

        $sales = $query->orderBy('employee_id')->get();

        $excel_name = "VENTAS_{$filters[request()->type]}_REALIZADAS_POR_{$user->name}_{$from_format}_A_{$to_format}.xlsx";

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

    public function downloadTicketSale(){
        $request = request();
        $folio   = $request->folio;
        $sale    = Sale::where('folio',$folio)->first();
        if( !$sale ){ abort(404); } // If ticket is not found, return page 404
        $pdf_doc = PDF::loadView('sales.ticket', compact('sale'))->setOptions(['defaultFont' => 'sans-serif']);
        $date    = $sale->created_at->format('d-m-Y');

        return $pdf_doc->download("Ticket-{$folio}-{$date}.pdf");
    }

    public function getTicketViewData(){
        $request = request();
        $folio   = $request->folio;
        $sale    = Sale::where('folio',$folio)->first();
        if( !$sale ){ abort(404); } // If ticket is not found, return page 404
        return view('sales.ticket',compact('sale'))->render();
    }

    public function downloadTicket( Request $request ) {

        $folio = $request->f;
        $array = explode('@', $folio);

        $sale = Sale::where([
            ['folio', '=', $array[0]],
            ['client_id', '=', $array[1]],
        ])->first();

        if( !$sale )
            abort(404);

        view()->share('sale', $sale);

        $pdf_doc    = PDF::loadView('sales.ticket', compact('sale'))->setOptions(['defaultFont' => 'sans-serif']);
        $date       = $sale->created_at->format('d-m-Y');

        return $pdf_doc->download("Ticket-{$array[0]}-{$date}.pdf");

    }

}
