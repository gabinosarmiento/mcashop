<!doctype html>
<html lang="es">
    <head>
        <meta charset="UTF-8"/>
        <title>
            Cotización - {{ env('APP_NAME') }}
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
            }
            p {
                margin: 10px 0;
            }
            a {
                color: #054F9D;
                text-decoration: none;
            }
            table {
                border-collapse: collapse;
                width: 100%;
                margin: 15px 0;
            }
            table th,
            table td {
                border: 1px solid #dee2e6;
                padding: 4px;
            }
            table thead {
                background: #f9f9f9;
                text-align: left;
            }
            ul {
                padding-left: 0;
                margin: 0 0 15px 0;
            }
            .gratitude {
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
        <img src="{{ asset('images/logo.svg') }}" alt="MCAShop" width="150" class="logo"/>
        <h2>
            ¡Hola {{ $checkout['address']['name'] }}!
        </h2>
        <p>
            Has recibido la cotización con folio
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
            A continuación te proporcionamos los detalles de tu cotización.
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
                <tr>
                    <th class="right" colspan="6">
                        IVA
                    </th>
                    <th class="right">
                        {{ number_format($checkout['vat'] , 2) }}
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
            Recuerda que:
        </h3>
        <ul>
            <li>
                La vigencia de esta cotización es de 24 horas o hasta agotar existencias.
            </li>
            <li>
                Los precios de la cotización están en pesos mexicanos.
            </li>
            <li>
                Los precios y la disponibilidad de los productos están sujetos a cambios.
            </li>
            <li>
                Solo aceptamos pago anticipado y de contado, salvo indicación contraria.
            </li>
            <li>
                Después de realizar tu pago, necesitamos 24 horas para procesar el pedido.
            </li>
            <li>
                Nuestro tiempo de entrega es de 1 a 5 días hábiles, excepto en productos especiales o de importación.
            </li>
            <li>
                Los gastos y tiempos de envío dependen de nuestros proveedores.
            </li>
            <li>
                El envío se realiza por vía terrestre.
            </li>
            <li>
                La garantía de nuestros productos está sujeta a los términos y condiciones del fabricante.
            </li>
            <li>
                Puedes dar seguimiento a tu cotización desde tu cuenta, en la sección Cotizaciones.
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
        <ul>
            <li>
                <strong>
                    Teléfono:
                </strong>
                951 501 62 00
            </li>
            <li>
                <strong>
                    Correo electrónico:
                </strong>
                ventas@mcashop.mx
            </li>
            <li>
                <strong>
                    Dirección:
                </strong>
                Tulipanes 101, El Bosque Norte, Santa Lucía del Camino, Oaxaca, 71244
            </li>
        </ul>
        <p class="gratitude">
            Gracias por tu cotización, esperamos verte pronto.
            <br/>
            Equipo
            <strong>
                {{ env('APP_NAME') }}
            </strong>
            <br/>
            Este correo electrónico se envió a: {{ $checkout['address']['email'] }}
        </p>
    </body>
</html>
