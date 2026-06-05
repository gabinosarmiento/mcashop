<figure class="card @if($product['inventory']['stock']> 0) card-hover @endif">
   <a href="{{ route('marca', array($product['brand_id'], str($product['brand']['name'])->slug())) }}" class="card-brand brand-sm item-scale" target="_blank">
      <img src="{{ asset("images/{$product['brand']['image']}") }}" class="img-fluid" alt="{{ $product['brand']['name'] }}" width="50" height="50"/>
   </a>
   <div class="img-container card-image">
      <a href="{{ route('producto', array($product['id'], str($product['name'])->slug())) }}">
         <img src="{{ asset("images/{$product['image']}") }}" class="rounded-md img-cover img-loading" alt="{{ $product['sku'] }}" width="180" height="180" loading="lazy"/>
      </a>
   </div>
   <figcaption class="card-body">
      <span class="card-sku">
         SKU: {{ $product['sku'] }}
      </span>
      <div class="card-rated">
         <i class="fal fa-star"></i>
         <i class="fal fa-star"></i>
         <i class="fal fa-star"></i>
         <i class="fal fa-star"></i>
         <i class="fal fa-star"></i>
         <span>
            0 Opiniones
         </span>
      </div>
      <a href="{{ route('producto', array($product['id'], str($product['name'])->slug())) }}" class="card-text truncate truncate-2">
         {{ $product['name'] }}
      </a>
   </figcaption>
   <div class="card-footer text-mca">
      <div class="card-stock">
         <strong>
            ${{ number_format($product['inventory']['price'], 2) }}
         </strong>
         <span>
            <i class="fal fa-box"></i>
            {{ $product['inventory']['stock'] }}
         </span>
      </div>
      <div class="text-center">
         @if($product['inventory']['stock'] > 0)
         <button id="click-cart-add-{{ $product['inventory']['id'] }}" class="btn btn-sm btn-outline-mca w-100" data-action="{{ route('carrito/agregar', [$product['inventory']['id'], 1]) }}">
            <i class="fal fa-cart-shopping"></i>
            Agregar
            <span class="d-none d-md-inline-block">
               a carrito
            </span>
         </button>
         @else
         <small>
            Sin existencias
         </small>
         @endif
      </div>
   </div>
</figure>