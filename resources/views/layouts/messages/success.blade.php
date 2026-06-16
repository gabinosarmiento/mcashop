<!doctype html>
<html lang="es">
    <head>
        <meta charset="UTF-8"/>
        <title>
            Pedido - {{ env('APP_NAME') }}
        </title>
        <style>
            body {
                font-family: Arial, sans-serif;
                font-size: 14px;
                color: #333;
                margin: 0;
                padding: 20px;
            }
            img {
                display: block;
                margin: 0 auto 20px auto;
            }
            h2 {
                color: #054F9D;
                text-align: center;
            }
            h3 {
                color: #054F9D;
                margin-top: 20px;
                margin-bottom: 0;
            }
            p {
                margin-top: 4px;
                margin-bottom: 0;
            }
            a {
                color: #054F9D;
                text-decoration: none;
            }
            table {
                width: 100%;
                margin-top: 20px;
                border-collapse: collapse;
            }
            table th,
            table td {
                padding: 4px;
                text-align: left;
                border: 1px solid #dee2e6;
            }
            thead th {
                background: #f9f9f9;
            }
            ul {
                padding: 0;
                margin-top: 4px;
                margin-bottom: 0;
            }
            li {
                margin-bottom: 2px;
            }
            .bg {
                background: #f9f9f9;
            }
            .auto {
                width: auto;
                margin-top: 4px;
            }
            .gratitude {
                margin-top: 20px;
                color: #054F9D;
            }
            .clean {
                list-style: none;
            }
            .center {
                text-align: center;
            }
            .right {
                text-align: right;
            }
            .left {
                text-align: left;
            }
    </style>
    </head>
    <body>
        <img src="{{ asset('images/logo.svg') }}" alt="MCAShop" width="150"/>
        <h2>
            ¡Hola {{ $checkout['address']['name'] }}!
        </h2>
        <p>
            Has recibido el comprobante de tu pedido con folio
            <strong>
                {{ $checkout['folio'] }}
            </strong>
            de
            <strong>
                {{ env('APP_NAME') }}
            </strong>
            exitosamente.
        </p>
        <p>
            A continuación te proporcionamos los detalles de tu pedido.
        </p>
        <table>
            <thead>
                <tr>
                    <th class="center">
                        No
                    </th>
                    <th  class="center">
                        Sku
                    </th>
                    <th class="center">
                        Descripción
                    </th>
                    <th class="center">
                        Marca
                    </th>
                    <th class="center">
                        Cantidad
                    </th>
                    <th class="center">
                        Valor
                    </th>
                    <th class="center">
                        Importe
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach($checkout['products'] as $product)
                <tr>
                    <td class="center">
                        {{ $loop->iteration }}
                    </td>
                    <td>
                        {{ $product['sku'] }}
                    </td>
                    <td>
                        {{ $product['name'] }}
                    </td>
                    <td>
                        {{ $product['brand'] }}
                    </td>
                    <td class="center">
                        {{ $product['quantity'] }}
                    </td>
                    <td class="right">
                        {{ number_format($product['unit'], 2) }}
                    </td>
                    <td class="right">
                        {{ number_format($product['subtotal'], 2) }}
                    </td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th class="right" colspan="6">
                        Subtotal
                    </th>
                    <th class="right">
                        {{ number_format($checkout['subtotal'], 2) }}
                    </th>
                </tr>
                <tr>
                    <th class="right" colspan="6">
                        Envío
                    </th>
                    <th class="right">
                        {{ number_format($checkout['shipment'], 2) }}
                    </th>
                </tr>
                @if($checkout['discount'] > 0)
                <tr>
                    <th class="right" colspan="6">
                        Descuento
                    </th>
                    <th class="right">
                        -{{ number_format($checkout['discount'], 2) }}
                    </th>
                </tr>
                @endif
                <tr>
                    <th class="right" colspan="6">
                        IVA
                    </th>
                    <th class="right">
                        {{ number_format($checkout['vat'], 2) }}
                    </th>
                </tr>
                <tr>
                    <th class="right" colspan="6">
                        Total
                    </th>
                    <th class="right">
                        {{ number_format($checkout['total'], 2) }}
                    </th>
                </tr>
                <tr>
                    <th colspan="7" class="left">
                        {{ number_text($checkout['total']) }}
                    </th>
                </tr>
            </tfoot>
        </table>
        <h3>
            Transferencia o depósito bancario
        </h3>
        <table class="auto">
            <tr>
                <th class="bg">
                    Beneficiario
                </th>
                <td>
                    Mayoristas en Cómputo de Antequera, S.A. de C.V.
                </td>
            </tr>
            <tr>
                <th class="bg">
                    Cuenta
                </th>
                <td>
                    0179712348
                </td>
            </tr>
            <tr>
                <th class="bg">
                    CLABE
                </th>
                <td>
                    012610001797123486
                </td>
            </tr>
        </table>
        <h3>
            Recuerda que
        </h3>
        <ul class="clean">
            <li>
                Si tu pago se realizará por transferencia o depósito bancario, tienes 24 horas para completarlo y reportarlo al correo ventas@mcashop.mx.
            </li>
            <li>
                Después de comprobar tu pago, necesitamos 24 horas para procesar el pedido.
            </li>
            <li>
                Nuestro tiempo de entrega es de 1 a 5 días hábiles.
            </li>
            <li>
                El envío se realiza por vía terrestre.
            </li>
             <li>
                La garantía de nuestros productos está sujeta a los términos y condiciones del fabricante.
            </li>
            <li>
                Puedes dar seguimiento a tu pedido desde tu cuenta, en la sección Pedidos.
            </li>
        </ul>
        <h3>
            Servicio a clientes
        </h3>
        <p>
            Si tienes alguna duda o pregunta, no dudes en contactarnos o revisar nuestras políticas en nuestra tienda en línea.
            <a href="https://mcashop.mx/" target="_blank">
                mcashop.mx
            </a>
        </p>
        <ul class="clean">
            <li>
                <strong>
                    Teléfono
                </strong>
                951 501 62 00
            </li>
            <li>
                <strong>
                    Correo electrónico
                </strong>
                ventas@mcashop.mx
            </li>
            <li>
                <strong>
                    Dirección
                </strong>
                Tulipanes 101, El Bosque Norte, Santa Lucía del Camino, Oaxaca, 71244
            </li>
        </ul>
        <p class="gratitude">
            Gracias por tu compra, esperamos verte pronto.
            <br/>
            Equipo
            <strong>
                {{ env('APP_NAME') }}
            </strong>
            <br/>
            Este correo electrónico se envió a {{ $checkout['address']['email'] }}
        </p>
    </body>
</html>
