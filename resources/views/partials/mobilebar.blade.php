@isset($data['menu'])
<div class="offcanvas offcanvas-start" tabindex="-1" id="mobile-sidebar">
    <div class="offcanvas-header">
        <a href="{{ route('inicio') }}">
            <img src="{{ asset('images/logo.svg') }}" class="logo" alt="mcashop" width="135"/>
        </a>
        <button type="button" class="btn-close position-absolute end-0 me-3" data-bs-dismiss="offcanvas"></button>
    </div>
    <div class="offcanvas-body">
        <nav class="sidebar-nav mb-0">
            <ul class="list-unstyled" id="brand-sidebar">
                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ route('marcas') }}">
                        Marcas
                    </a>
                </li>
                @foreach($data['menu'] as $menu)
                @include('partials.mobilebarsubitem', ['item' => $menu, 'submenu' => false ])
                @endforeach
            </ul>
        </nav>
    </div>
</div>
@endisset