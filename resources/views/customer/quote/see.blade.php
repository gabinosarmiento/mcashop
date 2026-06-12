<div class="overlap-wrap-md">
    <div class="overlap-header">
        <div class="overlap-close"></div>
        Consultar
    </div>
    <div class="overlap-body">
        <ul class="nav nav-pills justify-content-center mb-4">
            <li class="nav-item">
                <button class="nav-link active" data-bs-toggle="pill" data-bs-target="#quote-tab">
                    Cotización
                </button>
            </li>
            <li class="nav-item">
                <button class="nav-link" data-bs-toggle="pill" data-bs-target="#products-tab">
                    Productos
                </button>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane fade show active" id="quote-tab">
                <table class="table table-borderless">
                    <tr>
                        <th width="100">
                            Id
                        </th>
                        <td>
                            {{ $data['id'] }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Folio
                        </th>
                        <td>
                            {{ $data['folio'] }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Peso
                        </th>
                        <td>
                            {{ $data['freight'] }}
                            <small>
                                kg
                            </small>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Monto
                        </th>
                        <td>
                            {{ number_format($data['amount'], 2) }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            IVA
                        </th>
                        <td>
                            {{ number_format($data['vat'], 2) }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Total
                        </th>
                        <td>
                            {{ number_format($data['total'], 2) }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Factura
                        </th>
                        <td>
                            {{ $data['invoice'] ? 'Requerida' : 'No requerida' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Creado
                        </th>
                        <td>
                            {{ $data['created_at'] }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Actualizado
                        </th>
                        <td>
                            {{ $data['updated_at'] }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Estatus
                        </th>
                        <th class="{{ $data['status'] }}">
                            {{ $data['status'] }}
                        </th>
                    </tr>
                </table>
            </div>
            <div class="tab-pane fade" id="products-tab">
                <div class="box">
                    <div class="box-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead class="header">
                                    <tr>
                                        <th colspan="2">
                                            Producto
                                        </th>
                                        <th width="130" class="text-end">
                                            Importe
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($data['products'] as $product)
                                    <tr>
                                        <td width="30">
                                            {{ $product['quantity'] }}
                                        </td>
                                        <td>
                                            {{ $product['name'] }}
                                            <span class="badge border text-body-secondary">
                                                {{ $product['sku'] }}
                                            </span>
                                        </td>
                                        <td class="text-end">
                                            <small>
                                                $
                                            </small>
                                            {{ number_format($product['subtotal'], 2) }}
                                        </td>
                                    </tr>
                                    @endforeach
                                    <tr>
                                        <th colspan="2" class="text-end">
                                            Subtotal
                                        </th>
                                        <th class="text-end">
                                            <small>
                                                $
                                            </small>
                                            {{ number_format($data['subtotal'], 2) }}
                                        </th>
                                    </tr>
                                    <tr>
                                        <th colspan="2" class="text-end">
                                            Envío
                                        </th>
                                        <th class="text-end">
                                            <small>
                                                $
                                            </small>
                                            {{ number_format($data['shipment'], 2) }}
                                        </th>
                                    </tr>
                                    <tr>
                                        <th colspan="2" class="text-end">
                                            IVA
                                        </th>
                                        <th class="text-end">
                                            <small>
                                                $
                                            </small>
                                            {{ number_format($data['vat'], 2) }}
                                        </th>
                                    </tr>
                                    <tr>
                                        <th colspan="2" class="text-end">
                                            Total
                                        </th>
                                        <th class="text-end">
                                            <small>
                                                $
                                            </small>
                                            {{ number_format($data['total'], 2) }}
                                        </th>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
