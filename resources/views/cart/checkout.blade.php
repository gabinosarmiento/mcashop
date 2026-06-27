@extends('layouts.site')
@section('content')
<div class="wrapper-md-bottom">
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
            <div class="section-subtitle">
                Hemos precargado los datos de tu última compra para agilizar el proceso.
                <span class="d-block text-primary">
                    Revisa la información antes de continuar.
                </span>
            </div>
        </h2>
        <div class="row g-4">
            <div class="col-md-8 col-lg-9">
                <div class="d-flex flex-column gap-4">
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
                                        <th width="92">
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
                                        <th rowspan="7">
                                            Dirección
                                        </th>
                                        <td>
                                            {{ $data['address']['street'] }}
                                            <span class="badge text-bg-light text-body-tertiary">
                                                calle
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            {{ $data['address']['city'] }}
                                            <span class="badge text-bg-light text-body-tertiary">
                                                ciudad
                                            </small>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            {{ $data['address']['state'] }}
                                            <span class="badge text-bg-light text-body-tertiary">
                                                estado
                                            </small>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            {{ $data['address']['zc'] }}
                                            <span class="badge text-bg-light text-body-tertiary">
                                                cp
                                            </small>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            {{ $data['address']['country'] }}
                                            <span class="badge text-bg-light text-body-tertiary">
                                                país
                                            </small>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            {{ $data['address']['streets'] }}
                                            <span class="badge text-bg-light text-body-tertiary">
                                                entrecalles
                                            </small>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            {{ $data['address']['reference'] }}
                                            <span class="badge text-bg-light text-body-tertiary">
                                                referencia
                                            </small>
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
                    <div class="box box-blue">
                        <div class="box-header">
                            <div class="box-title">
                                Productos en tu carrito
                            </div>
                        </div>
                        <div class="box-body">
                            <div id="table-checkout" class="container">
                                @foreach($data['products'] as $item)
                                <div class="row box-row">
                                    <div class="col-12 col-lg-8">
                                        <div class="d-flex gap-2">
                                            <div class="image-wrap">
                                                <img src="{{ asset($item['image']) }}" class="img-cover" alt="{{ $item['sku'] }}" width="50" height="50" loading="lazy"/>
                                            </div>
                                            <a href="{{ route('producto', array($item['product_id'], str($item['name'])->slug())) }}">
                                                <small>
                                                    {{ $item['name'] }}
                                                    <span class="badge badge-subtle">
                                                        Stock: {{ $item['stock'] }}
                                                    </span>
                                                </small>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-4">
                                        <div class="box-item box-between box-lg-end w-100">
                                            <span>
                                                {{ $item['quantity'] }}
                                                <i class="fa-light fa-box"></i>
                                            </span>
                                            <strong class="text-money">
                                                {{ number_format($item['total'], 2) }}
                                            </strong>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-lg-3">
                <div class="d-flex flex-column gap-4">
                    <div class="box box-blue card-hover">
                        <div class="box-header">
                            <div class="box-title">
                                Resumen del pedido
                            </div>
                        </div>
                        <div class="box-body">
                            <table class="table table-borderless">
                                <tr>
                                    <td colspan="2">
                                        <strong>
                                            ({{ count($data['products']) }}) Productos
                                        </strong>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Subtotal
                                    </td>
                                    <th class="text-end">
                                        <span class="text-money">
                                            {{ number_format($data['subtotal'], 2) }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Envio
                                    </td>
                                    <th class="text-end">
                                        <span class="text-money">
                                            {{ number_format($data['shipment'], 2) }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        IVA
                                    </td>
                                    <th class="text-end">
                                        <span class="text-money">
                                            {{ number_format($data['vat'], 2) }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        Total
                                    </th>
                                    <th class="text-end">
                                        <strong class="text-money">
                                            {{ number_format($data['total'], 2) }}
                                        </strong>
                                    </th>
                                </tr>
                            </table>
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
                                Para facturar, <a href="{{ route('cliente/facturacion') }}">registra tus datos fiscales</a>
                            </div>
                            @endif
                            <a class="btn btn-light w-100 mb-2" href="{{ route('carrito/cotizar') }}">
                                Hacer cotización
                            </a>
                             @if($data['shipping'] > 0.0)
                            <button id="action-cart-mercadopago" class="btn btn-icon btn-primary w-100 fw-semibold" data-action="{{ route('carrito/mercadopago') }}" data-overlap-show="#overlap-one">
                                Pagar con Mercado Pago
                            </button>
                            <div id="wallet_container"></div>
                            @endif
                        </div>
                    </div>
                    <div class="card card-blue card-hover">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start">
                                <h5 class="text-primary-emphasis fw-bold">
                                    Ahorra {{ DISCOUNT }}% pagando con BBVA
                                    <small class="d-block text-muted">
                                        Transferencia o depósito bancario
                                    </small>
                                </h5>
                                <span class="badge badge-subtle">
                                    -{{ DISCOUNT }}%
                                </span>
                            </div>
                            <div class="d-flex flex-column gap-2">
                                <table class="small">
                                    <tr>
                                        <th colspan="2">
                                            Mayoristas en Cómputo de Antequera, S.A. de C.V.
                                        </th>
                                    </tr>
                                    <tr>
                                        <td>
                                            Cuenta
                                        </td>
                                        <th>
                                            0179712348
                                        </th>
                                    </tr>
                                    <tr>
                                        <td>
                                            CLABE
                                        </td>
                                        <th>
                                            012610001797123486
                                        </th>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <small class="text-muted">
                                                Tendrás 24 horas para realizar el pago y enviar tu comprobante a <a href="mailto:ventas@mcashop.mx" class="fw-semibold">ventas@mcashop.mx</a>.
                                            </small>
                                        </td>
                                    </tr>
                                </table>
                                <table>
                                    <tr>
                                        <td>
                                            <small>
                                                Ahorras
                                            </small>
                                        </td>
                                        <th class="text-end">
                                            <span class="text-money">
                                                {{ number_format(discount_calculate($data['total'], DISCOUNT), 2) }}
                                            </span>
                                        </th>
                                    </tr>
                                    <tr>
                                        <th>
                                            Total a pagar
                                        </th>
                                        <th class="text-end align-bottom" width="120">
                                            <strong class="text-money">
                                                {{ number_format(discount_breakdown($data['total'], DISCOUNT), 2) }}
                                            </strong>
                                        </th>
                                    </tr>
                                </table>
                                <a href="{{ route('carrito/depositar') }}" class="btn btn-subtle w-100 fw-semibold">
                                    Continuar con transferencia
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <ul class="list-unstyled list-sm">
                    <li>
                        <i class="fal fa-percent text-mca"></i>
                        <strong class="text-mca">
                            Aprovecha un {{ DISCOUNT }}% de descuento adicional al pagar mediante transferencia o depósito bancario en BBVA.
                        </strong>
                    </li>
                    <li>
                        <i class="fal fa-message-middle text-mca"></i>
                        <span>
                            Si tienes alguna duda o pregunta, puedes contactarnos o revisar nuestras políticas de <a href="{{ route('envios') }}" target="_blank">envíos</a> y <a href="{{ route('devoluciones') }}" target="_blank">devoluciones</a> en mcashop.mx.
                        </span>
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
</div>
@endsection
