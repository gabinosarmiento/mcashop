<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8"/>
        <title>
            Ficha {{ $data['folio'] }}
        </title>
        <style>
            @page {
                margin: 30px;
            }
            body {
                color: #000;
                font-size: 10px;
                font-family: DejaVu Sans, sans-serif;
            }
            table {
                width: 100%;
                border-collapse: collapse;
            }
            th, td {
                padding: 4px;
                vertical-align: top;
                border: 1px solid #000;
            }
            small {
            }
            .center {
                text-align: center;
            }
            .left {
                text-align: left;
            }
            .bold {
                font-weight: bold;
            }
            .title {
                font-size: 12px;
            }
            .no-margin {
                margin: 0;
            }
            .amount {
                font-size: 16px;
            }
            .margin-top {
                margin-top: 10px;
            }
            .margin-bottom {
                margin-bottom: 10px;
            }
            .margin {
                margin: 10px;
            }
        </style>
    </head>
    <body>
        <div class="center">
            <img src="{{ asset('images/logo.svg') }}" width="130">
            <div class="title bold margin-top">
                Ficha de depósito
            </div>
            <div class="no-margin">
                {{ $data['folio'] }}
            </div>
            <div class="amount bold margin-top">
                ${{ number_format($data['total'], 2) }}
            </div>
            <p class="no-margin">
                Emitido {{ date('d/m/Y H:i', strtotime($data['printed'])) }}
            </p>
            <div class="margin-bottom">
                Válido hasta {{ date('d/m/Y H:i', strtotime($data['expires'])) }}
            </div>
        </div>
        <table>
            <tbody>
                <tr>
                    <th>
                        Banco
                    </th>
                    <td>
                        BBVA
                    </td>
                </tr>
                <tr>
                    <th>
                        Beneficiario
                    </th>
                    <td>
                        Mayoristas en Cómputo de
                        <br/>
                        Antequera, S.A. de C.V.
                    </td>
                </tr>
                <tr>
                    <th>
                        Cuenta
                    </th>
                    <td>
                        0179712348
                    </td>
                </tr>
                <tr>
                    <th>
                        CLABE
                    </th>
                    <td>
                        012610001797123486
                    </td>
                </tr>
                <tr>
                    <th>
                        Referencia
                    </th>
                    <td>
                        {{ $data['folio'] }}
                    </td>
                </tr>
            </tbody>
        </table>
        <div class="center">
            <div class="margin">
                Realiza tu depósito o transferencia utilizando el folio del pedido como referencia de pago.
            </div>
            <div class="bold margin-top">
                 Una vez realizado tu pago, envía tu comprobante a ventas@mcashop.mx
            </div>
            <p class="title bold margin-top">
                ¡Gracias!
            </p>
        </div>
    </body>
</html>
