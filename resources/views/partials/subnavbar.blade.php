@isset($data['menu'])
<nav class="navbar navbar-bottom">
    <div class="container">
        <ul class="nav">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('marcas') }}">
                    <i class="fal fa-copyright"></i>
                    Marcas
                </a>
            </li>
            <li class="nav-item dropdown">
                <button type="button" class="nav-link dropdown-toggle" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
                    <i class="fal fa-tag"></i>
                    Categorías
                </button>
                <ul class="dropdown-menu">
                    @foreach($data['menu'] as $menu)
                    @include('partials.subnavbarsubitem', ['item' => $menu])
                    @endforeach
                </ul>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="https://mca-soluciones.com.mx" target="_blank">
                    <i class="fal fa-wrench"></i>
                    Soluciones
                </a>
            </li>
        </ul>
    </div>
</nav>
@endisset