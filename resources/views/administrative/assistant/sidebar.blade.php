<nav class="sidebar-nav" id="sidebar-nav">
    <ul class="list-unstyled">
        <li>
            <a class="sidebar-link" href="{{ route('administrativo/auxiliar/producto') }}">
                <i class="fal fa-min fa-box"></i>
                Productos
            </a>
        </li>
        <li>
            <a class="sidebar-link" href="{{ route('administrativo/auxiliar/categoria') }}">
                <i class="fal fa-min fa-tag"></i>
                Categorías
            </a>
        </li>
        <li>
            <a class="sidebar-link" href="{{ route('administrativo/auxiliar/marca') }}">
                <i class="fal fa-min fa-copyright"></i>
                Marcas
            </a>
        </li>
        <li>
            <a class="sidebar-link" href="{{ route('administrativo/auxiliar/proveedor') }}">
                <i class="fal fa-min fa-truck-field"></i>
                Proveedores
            </a>
        </li>
        <li>
            <a class="sidebar-link" href="{{ route('administrativo/auxiliar/salud') }}">
                <i class="fal fa-heart-pulse"></i>
                Salud
            </a>
        </li>
        <li>
            <span class="sidebar-link sidebar-caret" aria-controls="taxonomies" aria-expanded="false" data-bs-target="#taxonomies" data-bs-toggle="collapse">
                <i class="fal fa-layer-group"></i>
                Taxonomías
            </span>
            <ul class="sidebar-submenu list-unstyled collapse" data-bs-parent="#sidebar-nav" id="taxonomies">
                <li class="sidebar-subitem">
                    <a class="sidebar-sublink" href="{{ route('administrativo/auxiliar/caracteristica') }}">
                        Características
                    </a>
                </li>
                <li class="sidebar-subitem">
                    <a class="sidebar-sublink" href="{{ route('administrativo/auxiliar/atributo') }}">
                        Atributos
                    </a>
                </li>
            </ul>
        </li>
        <li>
            <a class="sidebar-link" href="{{ route('administrativo/auxiliar/proceso') }}">
                <i class="fa-light fa-diagram-subtask"></i>
                Procesos
            </a>
        </li>
    </ul>
</nav>
