<figure class="card card-hover">
    <a href="{{ route('marca', [$product['brand_id'], str($product['brand']['name'])->slug()]) }}" class="card-brand brand-sm item-scale" target="_blank">
        <img src="{{ asset($product['brand']['image']) }}" class="img-fluid" alt="marca-logo"/>
    </a>
    <div class="card-img img-container">
        <a href="{{ route('producto', [$product['id'], str($product['name'])->slug()]) }}">
            <img src="{{ asset($product['image']) }}" class="img-cover img-loading rounded-3" alt="{{ $product['sku'] }}" width="226" height="226" loading="lazy"/>
        </a>
    </div>
    <figcaption class="card-inner">
        <div class="card-caption">
            <div class="card-rated">
                <span class="card-sku">
                    SKU: {{ $product['sku'] }}
                </span>
                <i class="fal fa-star"></i>
                <i class="fal fa-star"></i>
                <i class="fal fa-star"></i>
                <i class="fal fa-star"></i>
                <i class="fal fa-star"></i>
                <strong class="d-none d-sm-inline">
                    0 Opiniones
                </strong>
            </div>
            <div class="card-text truncate truncate-2">
                {{ $product['name'] }}
            </div>
            <div class="card-stock">
                ${{ number_format($product['inventory']['price'], 2) }}
                <span>
                    <i class="fal fa-box"></i>
                    {{ $product['inventory']['stock'] }}
                </span>
            </div>
            <ul class="card-taxonomy">
                @php($shown = 0)
                @foreach($product['features'] as $feature)
                @foreach($feature['attributes'] as $attribute)
                @if($shown >= 4)
                @break(2)
                @endif
                @if(in_array($attribute['attribute_id'], $product['showcase']))
                <li>
                    <div class="fw-medium">
                        {{ $attribute['attribute']['name'] }}
                    </div>
                    {{ $attribute['value'] }}
                </li>
                @php($shown++)
                @endif
                @endforeach
                @endforeach
            </ul>
            <a href="{{ route('producto', [$product['id'], str($product['name'])->slug()]) }}" class="btn btn-sm btn-icon btn-outline-primary w-100">
                <i class="fal fa-eyes"></i>
                Ver producto
            </a>
        </div>
    </figcaption>
    <div class="card-footer border-0">
        @if($product['inventory']['stock'] > 0)
        <button id="action-cart-add-{{ $product['inventory']['inventory_id'] }}" class="btn btn-sm btn-icon btn-outline-mca w-100" data-action="{{ route('carrito/agregar', $product['inventory']['inventory_id']) }}">
            <i class="fal fa-cart-shopping"></i>
            Agregar
            <span class="d-none d-lg-block">
                a carrito
            </span>
        </button>
        @else
        <small class="text-black-50">
         Sin existencias
        </small>
        @endif
    </div>
</figure>
