<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>
        @if ($data['type'] == 'individual')
            <span>Cliente {{ $data['client_information']['business_name'] }}</span>
        @else
            Lista de clientes
        @endif
    </title>
    <style>
        .header-data{
            width: 100%;
            margin-bottom: 2rem;
        }

        .card-client,
        .card-client-individual{
            padding: 10px;
            border: 1px solid #000000;
            border-radius: 1rem;
            height: 250px;
            max-height: 250px;
            display: inline-block;
            text-align: center;
        }

        .card-client{
            margin: 10px;
            width: 25%;
        }

        .card-client-individual{
            margin: 0 auto !important;
            width: 100%;
        }

        .qr-code{
            height: 100px;
            margin-bottom: 10px;
        }

        .client-name,
        .client-code{
            height: 75px;
        }
    </style>
</head>
<body>
    <div>
        <table class="header-data">
            <td style="text-align: left;">
                <h2>
                    @if ($data['type'] == 'individual')
                        <span>Cliente {{ $data['client_information']['business_name'] }}</span>
                    @else
                        Lista de clientes
                    @endif
                </h2>
            </td>
            <td>
                <!--LOGO-->
                <div style="text-align: right;">
                    <img src="{{ public_path('images/Logo.png') }}" width="200px" alt="">
                </div>
                <!--DESCRIPTION below logo-->
                <p style="width: 90%;margin: 0 0 0 auto;">
                    {{-- <span>Cecilia Chapman, 711-2880 Nulla St, Mankato</span>
                    <span>Mississippi 96522</span> --}}
                </p>
            </td>
        </table>
        @if ($data['type'] == 'individual')
            <div style="width: 100%;">
                <div class="card-client-individual">
                    <div class="qr-code">
                        <img src="data:image/png;base64,{{ DNS2D::getBarcodePNG($data['client_information']->code, 'QRCODE') }}" width="100px" alt="">
                    </div>
                    <div class="info">
                        <div class="client-name">
                            <span>
                                <strong>Cliente:</strong>
                            </span>
                            <br />
                            <span>{{ $data['client_information']->business_name }}</span>
                        </div>
                        <p class="client-code">
                            <strong>Código:</strong><br />
                            <span>{{ $data['client_information']->code }}</span>
                        </p>
                    </div>
                </div>
            </div>
        @elseif ($data['type'] == 'multiple')
            @if (count($data['client_information']) > 0)
                <div style="width: 100%;">
                    @foreach ($data['client_information'] as $information)
                        <div class="card-client">
                            <div class="qr-code">
                                <img src="data:image/png;base64,{{ DNS2D::getBarcodePNG($information->code, 'QRCODE') }}" width="100px" alt="">
                            </div>
                            <div class="info">
                                <div class="client-name">
                                    <span>
                                        <strong>Cliente:</strong>
                                    </span>
                                    <br />
                                    <span>{{ $information->business_name }}</span>
                                </div>
                                <div class="client-code">
                                    <span>
                                        <strong>Código:</strong>
                                    </span>
                                    <br />
                                    <span>{{ $information->code }}</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-center"></p>
            @endif
        @endif
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
</body>
</html>
