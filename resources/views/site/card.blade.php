<figure class="card card-hover">
    <a href="{{ route('marca', array($product['brand_id'], str($product['brand']['name'])->slug())) }}" class="card-brand brand-sm item-scale" target="_blank">
        <img src="{{ asset($product['brand']['image']) }}" class="img-fluid" alt="{{ $product['brand']['name'] }}" width="50" height="50"/>
    </a>
    <div class="card-img img-container">
        <a href="{{ route('producto', array($product['id'], str($product['name'])->slug())) }}">
            <img src="{{ asset($product['image']) }}" class="img-cover img-loading rounded-3" alt="{{ $product['sku'] }}" width="180" height="180" loading="lazy"/>
        </a>
    </div>
    <figcaption class="card-body">
        <div class="card-rated">
            <span class="card-sku">
                SKU: {{ $product['sku'] }}
            </span>
            <div>
                <i class="fal fa-star"></i>
                <i class="fal fa-star"></i>
                <i class="fal fa-star"></i>
                <i class="fal fa-star"></i>
                <i class="fal fa-star"></i>
                <span>
                    0 Opiniones
                </span>
            </div>
        </div>
        <a href="{{ route('producto', array($product['id'], str($product['name'])->slug())) }}" class="card-text truncate truncate-2">
            {{ $product['name'] }}
        </a>
    </figcaption>
    <div class="card-footer">
        <div class="card-stock">
            ${{ number_format($product['inventory']['price'], 2) }}
            <span>
                <i class="fal fa-box"></i>
                {{ $product['inventory']['stock'] }}
            </span>
        </div>
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
