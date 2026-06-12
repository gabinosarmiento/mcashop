<nav class="navbar navbar-mca navbar-expand-lg">
   <div class="container">
      <button type="button" id="sidebar-open" class="navbar-toggler" title="Menú">
         <i class="fal fa-bars"></i>
      </button>
      <a href="{{ route('inicio') }}">
         <img src="{{ asset('images/logo_white.svg') }}" alt="mcashop" width="166" height="37"/>
      </a>
      <ul class="nav nav-mca ms-lg-auto align-items-center">
         @auth('customer')
         <li class="nav-item dropdown">
            <a class="nav-link" role="button" data-bs-toggle="dropdown" aria-expanded="false">
               <span class="d-none d-sm-inline-block">
                  {{ auth('customer')->user()->name }}
               </span>
               <img class="navbar-avatar" src="{{ url('images/avatar.webp') }}" width="28" height="28" alt="..."/>
            </a>
            <div class="dropdown-menu dropdown-menu-end">
               <a class="dropdown-item" href="{{ route('cliente/cuenta') }}" aria-label="Ver cuenta">
                  <i class="fal fa-user"></i>
                  Cuenta
               </a>
               <a class="dropdown-item" href="{{ route('cliente/salir') }}" aria-label="Salir">
                  <i class="fal fa-right-from-bracket"></i>
                  Salir
               </a>
            </div>
         </li>
         @else
         <li class="nav-item">
            <a class="nav-link" href="{{ route('cliente/acceso') }}">
               <span class="d-none d-sm-inline-block">
                  Acceso
               </span>
               <i class="fa-solid fa-key"></i>
            </a>
         </li>
         @endauth
          <li class="nav-item">
            <a class="nav-link position-relative" href="{{ route('carrito') }}" data-tag="{{ count(session('_cart')) }}" aria-label="Ver a carrito">
               <span id="_cart" class="badge rounded-pill bg-danger badge-cart">
                  {{ count(session('_cart.products')) }}
               </span>
               <i class="fas fa-nav fa-bag-shopping"></i>
            </a>
         </li>
      </ul>
      <div id="dofinder-search" class="custom-search">
         <form id="dofinder-form">
            <input type="search" name="dofinder-input" id="dofinder-input" class="form-control" placeholder="Escribe el producto a buscar"/>
         </form>
      </div>
      <!-- <script>
         document.getElementById('dofinder-input').addEventListener('change', function (e) {
            gtag('event', 'search', {
               search_term: e.target.value
            });
         });
      </script> -->
   </div>
</nav>