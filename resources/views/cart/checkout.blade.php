@extends('layouts.customer')
@section('content')
<div class="container">
    {{ Breadcrumbs::render('carrito/continuar') }}
    @guest('customer')
    <div class="console">
        Necesitas una cuenta para continuar con tu compra
        <a href="{{ route('cliente/acceso') }}">
            (Registrarse)
        </a>
    </div>
    @else
    @empty($data['address'])
    <div class="console">
        Aún no has registrado una dirección.
        <a href="{{ route('cliente/direccion') }}">
            (Agregar dirección)
        </a>
    </div>
    @else
    <h2 class="section-title">
        Datos de envío
        <div class="section-message">
            Hemos precargado los datos de tu última compra para agilizar el proceso.
            <small class="text-danger d-block">
                Revisa la información antes de continuar.
            </small>
        </div>
    </h2>
    <div class="row">
        <div class="col-md-9">
            <div class="box box-blue">
                <div class="box-header">
                    <div class="box-title">
                        Productos en tu carrito
                    </div>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        <table id="table-checkout" class="table align-middle">
                            <tbody>
                                @foreach($data['products'] as $item)
                                <tr>
                                    <td>
                                        <a href="{{ route('producto', array($item['product_id'], str($item['name'])->slug())) }}">
                                            <div class="d-flex align-items-center gap-2">
                                                <div class="image-wrap">
                                                    <img src="{{ asset($item['image']) }}" class="img-cover" alt="{{ $item['sku'] }}" width="50" height="50" loading="lazy"/>
                                                </div>
                                                <small class="w-auto">
                                                    {{ $item['name'] }}
                                                    <span class="badge bg-primary">
                                                        Stock: {{ $item['stock'] }}
                                                    </span>
                                                </small>
                                            </div>
                                        </a>
                                    </td>
                                    <td width="100">
                                        {{ $item['quantity'] }}
                                    </td>
                                    <th width="120" class="text-end">
                                        <small>
                                            $
                                        </small>
                                        {{ number_format($item['total'], 2) }}
                                    </th>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="box box-blue">
                <div class="box-header">
                    <div class="box-title">
                        Dirección de entrega
                    </div>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="table table-borderless">
                            <tr>
                                <th width="100">
                                    Nombre
                                </th>
                                <td>
                                    {{ $data['address']['name'] }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Correo
                                </th>
                                <td>
                                    {{ $data['address']['email'] }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Teléfono
                                </th>
                                <td>
                                    {{ $data['address']['phone'] }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Dirección
                                </th>
                                <td>
                                    <div>
                                        {{ $data['address']['street'] }}
                                        <small class="text-secondary">
                                            [ calle ]
                                        </small>
                                    </div>
                                    <div>
                                        {{ $data['address']['colony'] }}
                                        <small class="text-secondary">
                                            [ colonia ]
                                        </small>
                                    </div>
                                    <div>
                                        {{ $data['address']['city'] }}
                                        <small class="text-secondary">
                                            [ ciudad ]
                                        </small>
                                    </div>
                                    <div>
                                        {{ $data['address']['state'] }}
                                        <small class="text-secondary">
                                            [ estado ]
                                        </small>
                                    </div>
                                    <div>
                                        {{ $data['address']['country'] }}
                                        <small class="text-secondary">
                                            [ país ]
                                        </small>
                                    </div>
                                    <div>
                                        {{ $data['address']['zc'] }}
                                        <small class="text-secondary">
                                            [ cp ]
                                        </small>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Entrecalles
                                </th>
                                <td>
                                    {{ $data['address']['streets'] }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Referencia
                                </th>
                                <td>
                                    {{ $data['address']['reference'] }}
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="box-footer text-end">
                    <a href="{{ route('cliente/direccion') }}" class="btn btn-subtle-flat">
                        Administrar mi dirección
                        <i class="fal fa-arrow-right-long"></i>
                    </a>
                </div>
            </div>
            <div>
                <ul class="list-unstyled list-sm">
                    <li>
                        <i class="fal fa-percent text-mca"></i>
                        Aprovecha un {{ DISCOUNT }}% de descuento adicional al pagar mediante transferencia o depósito bancario en BBVA.
                    </li>
                    <li>
                        <i class="fal fa-message-middle text-mca"></i>
                        Si tienes alguna duda o pregunta, puedes contactarnos o revisar nuestras políticas de
                        <a href="{{ route('envios') }}" target="_blank">
                            envíos
                        </a>
                        y
                        <a href="{{ route('devoluciones') }}" target="_blank">
                            devoluciones
                        </a>
                        en mcashop.mx
                    </li>
                    <li>
                        <i class="fal fa-envelope text-mca"></i>
                        Al finalizar tu pedido y confirmar el pago, recibirás un correo electrónico con la confirmación de tu compra.
                    </li>
                    <li>
                        <i class="fal fa-truck text-mca"></i>
                        Tu envío quedará confirmado en el momento en que te enviemos un segundo correo notificándote que tu producto ha sido despachado.
                    </li>
                </ul>
            </div>
        </div>
        <div class="col-md-3">
            <div class="box box-blue">
                <div class="box-header">
                    <div class="box-title">
                        Resumen del pedido
                    </div>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="table table-borderless">
                            <tr>
                                <th colspan="2">
                                    ({{ count($data['products']) }}) Productos
                                </th>
                            </tr>
                            <tr>
                                <td>
                                    Subtotal
                                </td>
                                <td class="text-end">
                                    <small>
                                        $
                                    </small>
                                    {{ number_format($data['subtotal'], 2) }}
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Envio
                                </td>
                                <td class="text-end">
                                    @if($data['shipment'] > 0.0)
                                    <small>
                                        $
                                    </small>
                                    {{ number_format($data['shipment'], 2) }}
                                    @else
                                    <span class="text-mca">
                                        Cotizar
                                    </span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    IVA
                                </td>
                                <td class="text-end">
                                    <small>
                                        $
                                    </small>
                                    {{ number_format($data['vat'], 2) }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Total
                                </th>
                                <th class="text-end">
                                    <small>
                                        $
                                    </small>
                                    {{ number_format($data['total'], 2) }}
                                </th>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="box-footer">
                    @isset($data['billing'])
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="change-invoice" name="change-invoice" value="1" data-action="{{ route('carrito/facturar') }}" @checked(session('_invoice'))/>
                        <label class="form-check-label text-primary" for="change-invoice">
                            Requiero factura fiscal
                        </label>
                    </div>
                    @else
                    <div class="console mb-3">
                        Para facturar,
                        <a href="{{ route('cliente/facturacion') }}">
                            registra tus datos fiscales
                        </a>
                    </div>
                    @endif
                    @if($data['shipping'] > 0.0)
                    <a class="btn btn-light w-100 mb-2" href="{{ route('carrito/cotizar') }}">
                        Realizar cotización
                    </a>
                    <button id="click-cart-mercadopago" class="btn btn-mca w-100" data-action="{{ route('carrito/mercadopago') }}" data-overlapshow="#overlap-one">
                        Realizar pedido y pagar ahora
                    </button>
                    <div id="wallet_container"></div>
                    @endif
                </div>
            </div>
            <div class="console">
                <div class="mb-2">
                    <strong class="text-danger-emphasis">
                        Ahorra {{ DISCOUNT }}% pagando con BBVA
                    </strong>
                </div>
                <ul class="list-unstyled mb-2">
                    <li>
                        <strong>
                            Mayoristas en Cómputo de Antequera, S.A. de C.V.
                        </strong>
                    </li>
                    <li>
                        Cuenta
                        <strong>
                            0179712348
                        </strong>
                    </li>
                    <li>
                        CLABE
                        <strong>
                            012610001797123486
                        </strong>
                    </li>
                </ul>
                <p>
                    Si eliges pagar mediante transferencia bancaria o depósito en efectivo, dispondrás de 24 horas para realizar el pago y enviar tu comprobante a <a href="mailto:ventas@mcashop.mx">ventas@mcashop.mx</a>.
                </p>
                <div class="text-end">
                    Ahorras
                    <strong class="fs-6">
                        ${{ number_format(discount_calculate($data['total'], DISCOUNT), 2) }}
                    </strong>
                </div>
                <div class="text-end mb-3">
                    Total a pagar
                    <strong class="fs-6">
                        ${{ number_format(discount_breakdown($data['total'], DISCOUNT), 2) }}
                    </strong>
                </div>
                <a href="{{ route('carrito/depositar') }}" class="btn btn-subtle w-100">
                    Continuar con transferencia
                </a>
            </div>
        </div>
    </div>
</div>
<script>
    gtag('event', 'purchase', {
        currency: 'MXN',
        tax: {{ $data['vat'] }},
        value: {{ $data['total'] }},
        shipping: {{ $data['shipping'] }},
        items: {!! json_encode(array_map(function ($item) {
            return [
                'item_id'       => $item['sku'],
                'item_name'     => $item['name'],
                'item_brand'    => $item['brand'],
                'item_category' => $item['category'],
                'price'         => (string) $item['price'],
                'quantity'      => (string) $item['quantity'],
            ];
        }, $data['products'])) !!}
    });
</script>
@endempty
@endguest
</div>
@endsection
