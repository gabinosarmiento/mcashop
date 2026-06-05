<figure class="card card-translate @if($product['inventory']['stock']> 0) card-hover @endif">
   <a href="{{ route('marca', [$product['brand_id'], str($product['brand']['name'])->slug()]) }}" class="card-brand brand-sm item-scale" target="_blank">
      <img src="{{ asset("images/{$product['brand']['image']}") }}" class="img-fluid rounded-sm" alt="marca-logo"/>
   </a>
   <div class="img-container card-store">
      <a href="{{ route('producto', [$product['id'], str($product['name'])->slug()]) }}">
         <img src="{{ asset("images/products/{$product['image']}") }}" class="rounded-md img-cover img-loading" alt="{{ $product['sku'] }}" width="226" height="226" loading="lazy"/>
      </a>
   </div>
   <figcaption class="card-inner">
      <div class="card-caption">
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
         <p class="card-product-text card-product-title multiline-truncate">
            {{ $product['name'] }}
         </p>
         <div class="card-inventory d-flex justify-content-between">
            <strong>
               ${{ number_format($product['inventory']['price'], 2) }}
            </strong>
            <span>
               <i class="fal fa-box"></i>
               {{ $product['inventory']['stock'] }}
            </span>
         </div>
         <ul class="card-taxonomy">
            @php($shown = 0)
            @foreach($product['features'] as $feature)
            @foreach($feature['attributes'] as $attribute)
            @if($shown > 3)
            @break(2)
            @endif
            @foreach($product['category']['features'] as $featurex)
            @foreach($featurex['attributes'] as $attributex)
            @if($attribute['attribute_id'] === $attributex['attribute_id'])
            <li>
               <div class="font-weight-bold">
                  {{ $attribute['attribute']['name'] }}
               </div>
               {{ $attribute['value'] }}
            </li>
            @php($shown++)
            @endif
            @endforeach
            @endforeach
            @endforeach
            @endforeach
         </ul>
         <a href="{{ route('producto', [$product['id'], str($product['name'])->slug()]) }}" class="btn btn-sm btn-block btn-outline-primary">
            <i class="fal fa-box-open"></i>
            Ver producto
         </a>
      </div>
   </figcaption>
   <div class="card-footer">
      @if($product['inventory']['stock'] > 0)
      <button id="click-cart-add-{{ $product['inventory']['id'] }}" class="btn btn-sm btn-block btn-outline-mca" data-action="{{ route('carrito/agregar', [$product['inventory']['id'], 1]) }}">
         <i class="fal fa-cart-shopping"></i>
         Agregar
         <span class="d-none d-md-inline-block">
            a carrito
         </span>
      </button>
      @else
      Sin existencias
      @endif
   </div>
</figure>