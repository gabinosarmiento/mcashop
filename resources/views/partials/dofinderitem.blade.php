@empty($data)
<span class="text-mca">
    No hay resultados para estos parámetros.
</span>
@else
<div class="dofinder-title">
    <i class="fal fa-magnifying-glass"></i>
    {{ count($data['search']) }} resultados
</div>
<div class="dofinder-grid">
    @foreach($data['search'] as $product)
    <figure class="dofinder-card card-hover">
        <a href="{{ route('marca', [$product['brand_id'], str($product['brand']['name'])->slug()]) }}" class="dofinder-brand item-scale" target="_blank">
            <img src="{{ asset($product['brand']['image']) }}" class="img-fluid rounded-md" alt="{{ $product['brand']['name'] }}" width="50" height="50"/>
        </a>
        <div class="img-container dofinder-image">
            <a href="{{ route('producto', array($product['id'], str($product['name'])->slug())) }}" class="card-product-thumbnail">
                <img src="{{ asset($product['image']) }}" class="rounded-md img-cover img-loading" alt="{{ $product['sku'] }}" width="186" height="186" loading="lazy"/>
            </a>
        </div>
        <figcaption class="dofinder-card-body">
            <div class="dofinder-card-rated ">
                <span class="card-sku">
                    SKU: {{ $product['sku'] }}
                </span>
                <div>
                    <i class="fal fa-star"></i>
                    <i class="fal fa-star"></i>
                    <i class="fal fa-star"></i>
                    <i class="fal fa-star"></i>
                    <i class="fal fa-star"></i>
                </div>
            </div>
            <a href="{{ route('producto', array($product['id'], str($product['name'])->slug())) }}" class="dofinder-card-text truncate truncate-2">
                {{ $product['name'] }}
            </a>
        </figcaption>
    </figure>
    @endforeach
</div>
@endempty
