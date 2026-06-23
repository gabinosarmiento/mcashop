<nav class="sidebar-nav">
    <ul class="list-unstyled">
        <li>
            <a class="sidebar-link" href="{{ route('cliente/cuenta') }}" data-active="/cliente/cuenta">
                <i class="fal fa-user"></i>
                Cuenta
            </a>
        </li>
        <li>
            <a class="sidebar-link" href="{{ route('cliente/pedido') }}" data-active="/cliente/pedido">
                <i class="fal fa-box"></i>
                Pedidos
            </a>
        </li>
        <li>
            <a class="sidebar-link" href="{{ route('cliente/cotizacion') }}" data-active="/cliente/cotizacion">
                <i class="fal fa-file-lines"></i>
                Cotizaciones
            </a>
        </li>
        <li>
            <a class="sidebar-link" href="{{ route('cliente/direccion') }}" data-active="/cliente/direccion">
                <i class="fal fa-location-pin"></i>
                Dirección
            </a>
        </li>
        <li>
            <a class="sidebar-link" href="{{ route('cliente/facturacion') }}" data-active="/cliente/facturacion">
                <i class="fal fa-file"></i>
                Facturación
            </a>
        </li>
    </ul>
</nav>
