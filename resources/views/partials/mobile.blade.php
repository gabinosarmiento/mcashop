<div id="overlap-sidebar" class="overlap">
    <div class="overlap-wrap overlap-wrap-sm">
        <div class="overlap-header">
            <div class="overlap-close"></div>
            Menú
        </div>
        <div class="overlap-body">
            <nav class="sidebar-nav">
                <ul class="list-unstyled" id="parent-root">
                    <li class="sidebar-item">
                        <a class="sidebar-link font-weight-bold" href="{{ route('marcas') }}">
                            Consulta por marca
                        </a>
                    </li>
                    @foreach($data['menu'] as $menu)
                        @include('partials.mobilesubitem', ['item' => $menu, 'submenu' => false, 'path' => 'path-root', 'parent' => 'parent-root'])
                    @endforeach
                    <li class="sidebar-item">
                        <a class="sidebar-link font-weight-bold" href="{{ route('marcas') }}">
                            Promociones
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link font-weight-bold" href="{{ route('marcas') }}">
                            Soluciones
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</div>
