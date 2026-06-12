<nav class="sidebar-nav">
    <ul class="list-unstyled">
        <li>
            <a @class([ 'sidebar-link', 'active' => request()->routeIs('cliente/cuenta*')]) href="{{ route('cliente/cuenta') }}">
                <i class="fal fa-user"></i>
                Cuenta
            </a>
        </li>
        <li>
            <a @class([ 'sidebar-link', 'active' => request()->routeIs('cliente/pedido*')]) href="{{ route('cliente/pedido') }}">
                <i class="fal fa-box"></i>
                Pedidos
            </a>
        </li>
        <li>
            <a @class([ 'sidebar-link', 'active' => request()->routeIs('cliente/cotizacion*')]) href="{{ route('cliente/cotizacion') }}">
                <i class="fal fa-file-lines"></i>
                Cotizaciones
            </a>
        </li>
        <li>
            <a @class([ 'sidebar-link', 'active' => request()->routeIs('cliente/direccion*')]) href="{{ route('cliente/direccion') }}">
                <i class="fal fa-location-pin"></i>
                Dirección
            </a>
        </li>
        <li>
            <a @class([ 'sidebar-link', 'active' => request()->routeIs('cliente/facturacion*')]) href="{{ route('cliente/facturacion') }}">
                <i class="fal fa-file"></i>
                Facturación
            </a>
        </li>
    </ul>
</nav>
