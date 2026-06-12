@empty($cart['products'])
<div class="console">
    No hay productos en tu carrito por el momento
</div>
@else
<div class="row">
    <div class="col-md-9">
        <div class="box box-blue">
            <div class="box-header">
                <div class="box-title">
                    Detalles
                </div>
            </div>
            <div class="box-body">
                <div class="table-responsive">
                    <table id="table-checkout" class="table align-middle">
                        <tbody>
                            @foreach($cart['products'] as $item)
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
                                    <div class="d-flex align-items-center gap-2">
                                        <button type="button" class="btn btn-link" id="action-remove-cart-{{ $item['id'] }}" data-action="{{ route('carrito/remover', $item['id']) }}">
                                            <i class="fa-light fa-circle-xmark"></i>
                                        </button>
                                        <input type="text" name="quantity" id="change-quantity" class="form-control form-control-sm text-center" value="{{ $item['quantity'] }}" data-min="1" data-max="{{ $item['stock'] }}" data-action="{{ route('carrito/actualizar', $item['id']) }}"/>
                                    </div>
                                </td>
                                <th width="130" class="text-end">
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
        <div>
            <h5 class="fw-semibold">
                ¿Por qué comprar en <b>MCAShop</b>?
            </h5>
            <ul class="list-unstyled list-sm list-columns">
                <li>
                    <i class="fal fa-shield text-mca"></i>
                    Compra segura con protección de datos
                </li>
                <li>
                    <i class="fal fa-credit-card text-mca"></i>
                    Pagos protegidos a través de Mercado Pago
                </li>
                <li>
                    <i class="fal fa-box text-mca"></i>
                    Productos 100% nuevos y originales
                </li>
                <li>
                    <i class="fal fa-award-simple text-mca"></i>
                    Garantía original del fabricante
                </li>
                <li>
                    <i class="fal fa-lock text-mca"></i>
                    Sitio protegido con certificado DigiCert SSL
                </li>
                <li>
                    <i class="fal fa-file text-mca"></i>
                    Facturación fiscal disponible
                </li>
                <li>
                    <i class="fal fa-truck text-mca"></i>
                    Envíos asegurados a todo México
                </li>
            </ul>
        </div>
    </div>
    <div class="col-md-3">
        <div class="box box-blue">
            <div class="box-header">
                <div class="box-title">
                    Resumen
                </div>
            </div>
            <div class="box-body">
                <div class="table-responsive">
                    <table class="table table-borderless">
                        <tr>
                            <th colspan="2">
                                ({{ count($cart['products']) }}) Productos
                            </th>
                        </tr>
                        <tr>
                            <td>
                                Total
                                <small class="text-mca">
                                    (IVA incluido)
                                </small>
                            </td>
                            <th class="text-end">
                                <small>
                                    $
                                </small>
                                {{ number_format($cart['total'], 2) }}
                            </th>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="box-footer">
                <a id="checkout-begin" href="{{ route('carrito/continuar') }}" class="btn btn-mca w-100">
                    Continuar
                </a>
            </div>
        </div>
    </div>
</div>
<script>
    gtag('event', 'view_cart', {
        currency: 'MXN',
        value: {{ $cart['total'] }},
        items: {!! json_encode(
            array_map(function ($item) {
                return [
                    'item_id' => $item['sku'],
                    'item_name' => $item['name'],
                    'item_brand' => $item['brand'],
                    'item_category' => $item['category'],
                    'price' => $item['price'],
                    'quantity' => $item['quantity'],
                ];
            },
        $cart['products'])) !!}
    });
</script>
@endempty
