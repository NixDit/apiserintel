<!DOCTYPE html>
<html lang="en">
<!--begin::Head-->

<head>
    <base href="../../../">
    <meta charset="utf-8" />
    <style>
        * {
            font-size: 12px;
        }

        .ticket-container {
            display: flex;
            /* establish flex container */
            flex-direction: row;
            /* default value; can be omitted */
            flex-wrap: nowrap;
            /* default value; can be omitted */

        }

        small {
            font-size: .8em;
        }

        td,
        th,
        tr,
        table {
            border-top: 1px solid black;
            border-collapse: collapse;
        }

        tfoot {
            border-style: double none none none;
        }

        td.total,
        th.total {
            width: 65px;
            max-width: 65px;
            text-align: right;
        }
        .text-end {
            text-align: end
        }
        .text-center {
            text-align: center
        }
        .text-break {
            word-break: break-all;
        }
        .ticket {
            width: 200px;
            max-width: 200px;
        }

    </style>
</head>

<body>
    <div class="ticket-container">
        <div class="ticket">
            <h4 class="text-center">SERINTEL CELULAR</h6>
                <!--end::Title-->
                <!--begin::Direccion-->
                <div class="text-center">
                    <div>Calle Nacional #850</div>
                    <div>RFC: XXXXXXXXXX</div>
                    <div>TEL: 223 102 1029</div>
                    <div>{{ $sale->created_at->format('d/m/Y H:i A') }}</div>
                    <div>Folio: {{ $sale->folio }}</div>
                    <div>Cliente: {{ $sale->costumer->clientInformation->business_name }}</div>
                    <div>Vendio: {{ $sale->seller->fullName() }}</div>
                </div>
                <br>
                <!--end::Direccion-->
                <!--begin:: Table -->
                <div>
                    <!--begin::Table-->
                    <div>
                        <table>
                            <thead>
                                <tr>
                                    <th>Descripcion</th>
                                    <th>Cant.</th>
                                    <th>Precio</th>
                                    <th class="total">Importe</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($sale->products as $product)
                                    <tr>
                                        <td style="word-break: break-all;max-width: 35px !important;width: 100px;">{{ $product->name }}</td>
                                        <td class="text-center">{{ $product->pivot->quantity }}</td>
                                        <td> {{ $product->retail_price == 0 ? 'N/A' : '$ ' . number_format($product->retail_price, 2, '.', ',') }}
                                        </td>
                                        <td class="total">$
                                            {{ number_format($product->pivot->total, 2, '.', ',') }}<span
                                                class="text-danger"> *
                                            </span></td>
                                    </tr>
                                @empty
                                    <td>Sin productos</td>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <!--end::Table-->
                    <!--begin::Container-->
                    <div>
                        <br>
                        <!--begin::Section-->
                        <div>
                            <!--begin::Item-->
                            <div class="text-end" style="text-align: right">
                                <!--begin::Label-->
                                <div>Subtotal:&nbsp;&nbsp;<b>${{ number_format($sale->subtotal, 2, '.', ',') }}</b></div>
                                <!--end::Label-->
                            </div>
                            <!--end::Item-->
                            <!--begin::Item-->
                            <div class="text-end" style="text-align: right">
                                <!--begin::Label-->
                                <div>
                                    Total:&nbsp;<b>${{ number_format($sale->total, 2, '.', ',') }}</b>
                                </div>
                                <!--end::Label-->
                            </div>
                            <!--end::Item-->
                        </div>
                        <!--end::Section-->
                    </div>
                    <div>
                        <div class="text-end" style="text-align: right">
                            <span>*</span><small>El importe total incluye precios de mayoreo si aplica</small>
                        </div>
                    </div>
                    <br>
                    <!--end::Container-->
                </div>
                <!--end:: Table -->
                <br><br>
                <div class="text-center">
                    <div>GRACIAS POR SU COMPRA</div>
                    <div>www.serintel.com</div>
                </div>
        </div>
    </div>
    <!--end::Invoice 2 sidebar-->
</body>

</html>
