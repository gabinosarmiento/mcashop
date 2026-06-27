<nav class="navbar navbar-dark bg-dark navbar-expand-md">
    <div class="container-fluid">
        <a href="{{ route('administrativo/tablero') }}">
            <img src="{{ asset('images/logo_white.svg') }}" class="logo" alt="mcashop" height="28"/>
        </a>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item nav-customer dropdown">
                    <a class="nav-link px-0" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <span class="d-none d-sm-inline-block">
                            {{ auth('administrative')->user()->name }}
                        </span>
                        <div class="picture picture-xs picture-circle" >
                            <img src="{{ asset(auth('administrative')->user()->image) }}" width="28" height="28" alt="..."/>
                        </div>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end">
                        <a class="dropdown-item" href="#">
                            <i class="fal fa-cog"></i>
                            Configuración
                        </a>
                        <a class="dropdown-item" href="{{ route('administrativo/salir') }}">
                            <i class="fal fa-right-from-bracket"></i>
                            Salir
                        </a>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>
