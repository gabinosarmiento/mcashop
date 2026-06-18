@extends('layouts.site')
@section('title', "MCAShop - {$data['name'] }")
@section('description', str("{$data['sku']} {$data['subname']}")->
limit(150))
@section('metatag')
<meta property="og:title" content="{{ $data['name'] }}"/>
<meta property="og:image" content="{{ asset($data['image']) }}"/>
<meta property="og:url" content="{{ url()->current() }}"/>
<meta property="og:site_name" content="{{ env('APP_NAME') }}"/>
<meta property="og:type" content="product"/>
@endsection
@section('content')
<div class="container">
    {{ Breadcrumbs::render('producto', $data['breadcrumbs'], $data['sku']) }}
    <div class="wrapper-bottom">
        <div class="row">
            <div class="col-md-5 mb-4 mb-sm-0">
                <figure class="card card-product">
                    <a href="{{ route('marca', array($data['brand']['id'], str($data['brand']['name'])->slug())) }}" class="card-brand item-scale" target="_blank">
                        <img src="{{ asset($data['brand']['image']) }}" class="img-fluid" width="60" height="60" alt="{{ $data['brand']['name'] }}"/>
                    </a>
                    <div class="img-container">
                        <a class="card-product-cover MagicZoom" id="magic_carrusel" href="{{ asset($data['image']) }}" data-options="zoomDistance:30">
                            <img src="{{ asset($data['image']) }}" class="img-fluid img-loading" alt="Producto" fetchpriority="high" width="526" height="526"/>
                        </a>
                    </div>
                </figure>
                <ul class="list-inline text-center mb-3">
                    @foreach($data['images'] as $image)
                    <li class="list-item-thumbnail">
                        <div class="img-container">
                            <a data-zoom-id="magic_carrusel" href="{{ asset($image['name']) }}" data-image="{{ asset($image['name']) }}">
                                <img src="{{ asset($image['name']) }}" class="img-fluid img-loading" alt="thumbnail"/>
                            </a>
                        </div>
                    </li>
                    @endforeach
                </ul>
                <div class="d-flex justify-content-around">
                    <a href="{{ route('producto/descargar', $data['id']) }}" target="_blank">
                        <i class="fal fa-file"></i>
                        Ficha técnica
                    </a>
                </div>
            </div>
            <div class="col-md-7">
                <h1 class="fw-semibold">
                    {{ $data['name'] }}
                    <span class="d-block h4 text-mca">
                        {{ $data['subname'] ?? '' }}
                    </span>
                </h1>
                <div class="row">
                    <div class="col-md-7">
                        <div>
                            <span class="badge badge-product bg-primary">
                                SKU:
                                <span id="sku-copy">
                                    {{ $data['sku'] }}
                                </span>
                            </span>
                            <button class="btn btn-link btn-copy" data-target="#sku-copy">
                                <i class="fa-light fa-copy"></i>
                            </button>
                        </div>
                        <div class="card-rated fs-6">
                            <i class="fal fa-star"></i>
                            <i class="fal fa-star"></i>
                            <i class="fal fa-star"></i>
                            <i class="fal fa-star"></i>
                            <i class="fal fa-star"></i>
                            <span>
                                0 Opiniones
                            </span>
                        </div>
                        <div class="h5">
                            Información Técnica
                        </div>
                        <ul class="list-unstyled mb-2">
                            <li>
                                Marca:
                                <strong>
                                    {{ $data['brand']['name'] }}
                                </strong>
                            </li>
                            @php($shown = 0)
                            @foreach($data['features'] as $feature)
                            @foreach($feature['attributes'] as $attribute)
                            @if($shown >= 10)
                            @break(2)
                            @endif
                            @if(in_array($attribute['attribute_id'], $data['showcase']))
                            <li>
                                {{ $attribute['attribute']['name'] }}:
                                <strong>
                                    {{ $attribute['value'] }}
                                </strong>
                            </li>
                            @php($shown++)
                            @endif
                            @endforeach
                            @endforeach
                        </ul>
                        <a href="#producto-detalle" class="product-text text-mca d-block mb-2">
                            <i class="fa-light fa-clipboard-list"></i>
                            Ver todas las especificaciones
                        </a>
                        <a href="{{ route('categoria', [$data['category']['id'], str($data['category']['name'])->slug()]) }}" class="btn btn-outline-mca" role="button" title="{{ $data['category']['name'] }}" target="_blank">
                            Ver más productos {{ strtolower($data['category']['name']) }}
                        </a>
                    </div>
                    <div class="col-md-5">
                        <div class="h-100 d-flex flex-column align-items-end justify-content-end">
                            @isset($data['inventory'])
                            <!-- Product Inventory -->
                            <div class="sparkles">
                                <i class="fa-solid fa-sparkle sparkle sparkle-1"></i>
                                <i class="fa-solid fa-sparkle sparkle sparkle-2"></i>
                                <i class="fa-solid fa-sparkle sparkle sparkle-3"></i>
                            </div>
                            <div class="h2 fw-bolder">
                                ${{ number_format($data['inventory']['price'], 2) }}
                            </div>
                            <span class="text-shipping text-mca">
                                Más gastos de envío
                            </span>
                            <span class="badge badge-product bg-primary">
                                Existencias: {{ $data['inventory']['stock'] }}
                            </span>
                            @if($data['inventory']['stock'] > 0)
                            <button id="action-cart-add-{{ $data['inventory']['id'] }}" class="btn btn-mca" data-action="{{ route('carrito/agregar', $data['inventory']['id']) }}">
                                <i class="fal fa-cart-shopping"></i>
                                Agregar a carrito
                            </button>
                            <script>
                                gtag('event', 'view_item', {
                                    currency: 'MXN',
                                    value: {{ $data['inventory']['price'] }},
                                    items: [{
                                        item_id: '{{ $data['sku'] }}',
                                        item_name: '{{ $data['name'] }}',
                                        item_brand: '{{ $data['brand']['name'] }}',
                                        item_category: '{{ $data['category']['name'] }}',
                                        price: {{ $data['inventory']['price'] }},
                                        quantity: 1,
                                    }]
                                });
                            </script>
                            @endif
                            @endisset
                            @empty($data['inventory'])
                            <small class="text-primary d-block">
                                Producto no disponible.
                            </small>
                            @endisset
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="wrapper bg-light">
    <div class="container">
        <h2 class="section-title">
            {{ $data['category']['name'] }}
            <div class="section-message">
                Descubre las novedades más recientes en nuestro catálogo.
            </div>
        </h2>
        <div class="grid grid-products">
            @foreach($data['product_related'] as $product)
            @include('site.card', compact('product'))
            @endforeach
        </div>
    </div>
</div>
<div class="wrapper">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h2 class="section-title">
                    Complementos
                    <div class="section-message">
                        El toque especial para potenciar tu productividad.
                    </div>
                </h2>
                <div class="grid grid-products">
                    @foreach($data['category_related'] as $product)
                    @include('site.card', compact('product'))
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
<div class="wrapper bg-light">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h2 class="section-title">
                    Descripción
                    <div class="section-message">
                        Lo esencial en pocas palabras
                    </div>
                </h2>
                @if($data['description'])
                <p>
                    {!! $data['description'] !!}
                <p>
                @endif
                @if($data['review'])
                <div class="card">
                    <div class="card-body text-justify">
                        <p>
                            {{ $data['review'] }}
                        </p>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
<div class="wrapper" id="producto-detalle">
    <div class="container">
        <h2 class="section-title">
            Especificaciones
            <div class="section-message">
                Que no se te escape ni un detalle del producto.
            </div>
        </h2>
        <div class="accordion" id="accordion">
            @foreach($data['features'] as $features)
            <div class="accordion-item">
                <div class="accordion-header">
                    <button class="accordion-button fw-medium collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-{{ $loop->index }}" aria-expanded="true" aria-controls="collapse-{{ $loop->index }}">
                        {{ $features['feature']['name'] }}
                    </button>
                </div>
                <div id="collapse-{{ $loop->index }}" class="accordion-collapse collapse" data-bs-parent="#accordion">
                    <div class="accordion-body">
                        @foreach($features['attributes'] as $attribute)
                        <div>
                            {{ $attribute['attribute']['name'] }}:
                            <span class="fw-medium">
                                {{ $attribute['value'] }}
                            </span>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
<div class="wrapper bg-light">
    <div class="container">
        <div class="card rounded-5">
            <div class="row g-0">
                <div class="col-md-2 p-4">
                    <div class="img-container">
                        <img src="{{ asset($data['brand']['image']) }}" class="img-fluid img-loading rounded-4" alt="{{ $data['brand']['name'] }}"/>
                    </div>
                </div>
                <div class="col-md-10 p-4">
                    <div class="text-justify">
                        <p>
                            {!! $data['brand']['description'] !!}
                        </p>
                        <a href="{{ route('marca', array($data['brand']['id'], str($data['brand']['name'])->slug())) }}" target="_blank">
                            <i class="fal fa-box"></i>
                            Ver más productos {{ $data['brand']['name'] }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="wrapper">
    <div class="container">
        <h2>
            Navegación
            <div class="section-message">
                Termina de explorar lo que capturó tu atención.
            </div>
        </h2>
        <div class="grid grid-products">
            @foreach($data['product_recently'] as $product)
            @include('site.card', compact('product'))
            @endforeach
        </div>
    </div>
</div>
<div class="wrapper bg-light">
    <div class="container">
        <h2>
            Software
            <div class="section-message">
                Aplicaciones disponibles en nuestro catálogo.
            </div>
        </h2>
        <div class="grid grid-products">
            @foreach($data['category_software'] as $product)
            @include('site.card', compact('product'))
            @endforeach
        </div>
    </div>
</div>
@endsection
