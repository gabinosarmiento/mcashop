@empty($data['products'])
<div class="console">
    No hay productos en tu carrito por el momento
</div>
@else
<div class="row g-4">
    <div class="col-md-8 col-lg-9">
        <div class="box box-blue">
            <div class="box-header">
                <div class="box-title">
                    Productos en tu carrito
                </div>
            </div>
            <div class="box-body">
                <div id="table-carrito" class="container">
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
                                        <span class="badge bg-primary-subtle text-primary">
                                            Stock: {{ $item['stock'] }}
                                        </span>
                                    </small>
                                </a>
                            </div>
                        </div>
                        <div class="col-12 col-lg-4">
                            <div class="row align-items-center">
                                <div class="col-6 box-item box-lg-end">
                                    <input type="text" name="quantity" id="change-quantity" class="form-control form-control-sm text-center"  value="{{ $item['quantity'] }}" data-validate="integer|min:1|max:{{ $item['stock'] }}" data-action="{{ route('carrito/actualizar', $item['id']) }}" style="width:50px"/>
                                    <button type="button" class="btn btn-link" id="action-remove-cart-{{ $item['id'] }}" data-action="{{ route('carrito/remover', $item['id']) }}">
                                        <i class="fa-light fa-circle-xmark"></i>
                                    </button>
                                </div>
                                <div class="col-6 text-end">
                                    <strong class="text-money">
                                        {{ number_format($item['total'], 2) }}
                                    </strong>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4 col-lg-3">
        <div class="box box-blue">
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
                        <th>
                            Total
                            <small class="text-mca text-nowrap">
                                (con IVA)
                            </small>
                        </th>
                        <th class="text-end align-bottom" width="120">
                            <strong class="text-money">
                                {{ number_format($data['total'], 2) }}
                            </strong>
                        </th>
                    </tr>
                </table>
            </div>
            <div class="box-footer">
                <a id="checkout-begin" href="{{ route('carrito/continuar') }}" class="btn btn-mca w-100">
                    Continuar
                </a>
            </div>
        </div>
    </div>
    <div class="col-12">
        <h5 class="fw-semibold">
            ¿Por qué comprar en <strong>MCAShop</strong>?
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
    <script>
        gtag('event', 'view_cart', {
            currency: 'MXN',
            value: {{ $data['total'] }},
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
            $data['products'])) !!}
        });
    </script>
    @endempty
