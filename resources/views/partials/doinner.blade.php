@empty($data)
<span class="text-mca">
   No hay resultados para estos parámetros.
</span>
@else
<div class="dofinder-title">
   <i class="fal fa-magnifying-glass"></i>
   {{ count($data['search']) }} resultados
</div>
<div class="grid grid-searching">
   @foreach($data['search'] as $product)
   <figure class="card card-hover">
      <a href="{{ route('marca', [$product['brand_id'], str($product['brand']['name'])->slug()]) }}" class="card-brand item-scale" target="_blank">
         <img src="{{ asset($product['brand']['image']) }}" class="img-fluid rounded-md" alt="{{ $product['brand']['name'] }}" width="50" height="50"/>
      </a>
      <div class="img-container">
         <a href="{{ route('producto', array($product['id'], str($product['name'])->slug())) }}" class="card-product-thumbnail">
            <img src="{{ asset($product['image']) }}" class="rounded-md img-cover img-loading" alt="{{ $product['sku'] }}" width="186" height="186" loading="lazy"/>
         </a>
      </div>
      <figcaption class="card-body">
         <span class="card-sku text-truncate">
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
         <a href="{{ route('producto', array($product['id'], str($product['name'])->slug())) }}" class="card-product-text card-product-title multiline-truncate">
            {{ $product['name'] }}
         </a>
      </figcaption>
   </figure>
   @endforeach
</div>
@endempty
