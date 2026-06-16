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
            <span class="d-block text-primary">
                Revisa la información antes de continuar.
            </span>
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
                                    <td width="100" class="text-center">
                                        {{ $item['quantity'] }}
                                    </td>
                                    <th width="150" class="text-end">
                                        <small>
                                            $
                                        </small>
                                        {{ number_format($item['price'], 2) }}
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
                                <td colspan="2">
                                    {{ $data['address']['name'] }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Correo
                                </th>
                                <td colspan="2">
                                    {{ $data['address']['email'] }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Teléfono
                                </th>
                                <td colspan="2">
                                    {{ $data['address']['phone'] }}
                                </td>
                            </tr>
                            <tr>
                                <th rowspan="3">
                                    Dirección
                                </th>
                                <td>
                                    <div>
                                        {{ $data['address']['street'] }}
                                        <small class="text-secondary">
                                            calle
                                        </small>
                                    </div>
                                </td>
                                <td>
                                    <div>
                                        {{ $data['address']['colony'] }}
                                        <small class="text-secondary">
                                            colonia
                                        </small>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div>
                                        {{ $data['address']['city'] }}
                                        <small class="text-secondary">
                                            ciudad
                                        </small>
                                    </div>
                                </td>
                                <td>
                                    <div>
                                        {{ $data['address']['state'] }}
                                        <small class="text-secondary">
                                            estado
                                        </small>
                                    </div>

                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div>
                                        {{ $data['address']['country'] }}
                                        <small class="text-secondary">
                                            país
                                        </small>
                                    </div>
                                </td>
                                <td>
                                    <div>
                                        {{ $data['address']['zc'] }}
                                        <small class="text-secondary">
                                            cp
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
                        Si tienes alguna duda o pregunta, puedes contactarnos o revisar nuestras políticas de <a href="{{ route('envios') }}" target="_blank">envíos</a> y <a href="{{ route('devoluciones') }}" target="_blank">devoluciones</a> en mcashop.mx</li>
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
                        Hacer cotización
                    </a>
                    <button id="action-cart-mercadopago" class="btn btn-primary w-100 fw-semibold d-flex align-items-center justify-content-center gap-2" data-action="{{ route('carrito/mercadopago') }}" data-overlap-show="#overlap-one">
                        <i class="fa-regular fa-credit-card"></i>
                        Pagar con Mercado Pago
                    </button>
                    <div id="wallet_container"></div>
                    @endif
                </div>
            </div>
            <div class="card card-blue card-hover">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <div>
                            <div class="h5 text-primary-emphasis fw-bold">
                                Ahorra {{ DISCOUNT }}% pagando con BBVA
                            </div>
                            <div class="text-muted small">
                                Transferencia o depósito bancario
                            </div>
                        </div>
                        <span class="badge rounded-pill bg-primary-subtle text-primary-emphasis">
                            -{{ DISCOUNT }}%
                        </span>
                    </div>
                    <div class="small mb-3">
                        <strong>
                            Mayoristas en Cómputo de Antequera, S.A. de C.V.
                        </strong>
                        <br/>
                        Cuenta
                        <strong>
                            0179712348
                        </strong>
                        <br/>
                        CLABE
                        <strong>
                            012610001797123486
                        </strong>
                    </div>
                    <small class="text-muted mb-4">
                        Tendrás 24 horas para realizar el pago y enviar tu comprobante a <a href="mailto:ventas@mcashop.mx" class="fw-semibold text-decoration-none">ventas@mcashop.mx</a>.
                    </small>
                </div>
                <div class="card-footer">
                    <div class="d-flex justify-content-between small text-muted mb-2">
                        <span>
                            Ahorras
                        </span>
                        <strong>
                            <small>
                                $
                            </small>
                            {{ number_format(discount_calculate($data['total'], DISCOUNT), 2) }}
                        </strong>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="fw-semibold">
                            Total a pagar
                        </span>
                        <strong class="coupon-total">
                            <small>
                                $
                            </small>
                            {{ number_format(discount_breakdown($data['total'], DISCOUNT), 2) }}
                        </strong>
                    </div>
                    <a href="{{ route('carrito/depositar') }}" class="btn btn-subtle w-100 fw-semibold">
                        Continuar con transferencia
                    </a>
                </div>
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

