@extends('layouts.site')
@section('content')
<div class="wrapper-md">
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="grid grid-categories">
                    @foreach ($data['categories'] as $value)
                    <div class="card card-simple item-up">
                        <a href="{{ route('categoria', [$value['id'], str($value['name'])->slug()]) }}">
                            <div class="img-container">
                                <img src="{{ asset("images/{$value['image']}") }}" class="img-loading img-cover" alt="{{ $value['id'] }}" loading="lazy"/>
                            </div>
                            <div class="footer-categories d-none d-lg-block">
                                {{ $value['name'] }}
                            </div>
                        </a>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="row row-carousel d-none d-lg-flex">
            <div class="col-md-4 col-carousel">
                <div id="carousel_one" class="carousel slide" data-bs-ride="carousel" data-bs-interval="10300" data-bs-pause="false">
                    <div class="carousel-indicators">
                        <button type="button" data-bs-target="#carousel_one" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                        <button type="button" data-bs-target="#carousel_one" data-bs-slide-to="1" aria-label="Slide 2"></button>
                        <button type="button" data-bs-target="#carousel_one" data-bs-slide-to="2" aria-label="Slide 3"></button>
                    </div>
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <div class="img-container">
                                <img src="images/sliders/main_one.webp" class="img-loading img-fluid" alt="compra en mcashop" loading="lazy"/>
                            </div>
                        </div>
                        <div class="carousel-item">
                            <div class="img-container">
                                <img src="images/sliders/hikvision_one.webp" class="img-loading img-fluid" alt="compra en mcashop" loading="lazy"/>
                            </div>
                        </div>
                        <div class="carousel-item">
                            <div class="img-container">
                                <img src="images/sliders/dell_one.webp" class="img-loading img-fluid" alt="compra en mcashop" loading="lazy"/>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-carousel">
                <div id="carousel_two" class="carousel slide" data-bs-ride="carousel" data-bs-interval="10300" data-bs-pause="false">
                    <div class="carousel-indicators">
                        <button type="button" data-bs-target="#carousel_two" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                        <button type="button" data-bs-target="#carousel_two" data-bs-slide-to="1" aria-label="Slide 2"></button>
                        <button type="button" data-bs-target="#carousel_two" data-bs-slide-to="2" aria-label="Slide 3"></button>
                    </div>
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <div class="img-container">
                                <img src="images/sliders/main_two.webp" class="img-loading img-fluid" alt="compra en mcashop" loading="lazy"/>
                            </div>
                        </div>
                        <div class="carousel-item">
                            <div class="img-container">
                                <img src="images/sliders/hikvision_two.webp" class="img-loading img-fluid" alt="compra en mcashop" loading="lazy"/>
                            </div>
                        </div>
                        <div class="carousel-item">
                            <div class="img-container">
                                <img src="images/sliders/dell_two.webp" class="img-loading img-fluid" alt="compra en mcashop" loading="lazy"/>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-carousel">
                <div id="carousel_three" class="carousel slide" data-bs-ride="carousel" data-bs-interval="10300" data-bs-pause="false">
                    <div class="carousel-indicators">
                        <button type="button" data-bs-target="#carousel_three" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                        <button type="button" data-bs-target="#carousel_three" data-bs-slide-to="1" aria-label="Slide 2"></button>
                        <button type="button" data-bs-target="#carousel_three" data-bs-slide-to="2" aria-label="Slide 3"></button>
                    </div>
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <div class="img-container">
                                <img src="images/sliders/main_three.webp" class="img-loading img-fluid" alt="compra en mcashop" loading="lazy"/>
                            </div>
                        </div>
                        <div class="carousel-item">
                            <div class="img-container">
                                <img src="images/sliders/hikvision_three.webp" class="img-loading img-fluid" alt="compra en mcashop" loading="lazy"/>
                            </div>
                        </div>
                        <div class="carousel-item">
                            <div class="img-container">
                                <img src="images/sliders/dell_three.webp" class="img-loading img-fluid" alt="compra en mcashop" loading="lazy"/>
                            </div>
                        </div>
                    </div>
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
                    Cómputo
                    <div class="section-message">
                        Descubre las novedades más recientes en nuestro catálogo.
                    </div>
                </h2>
                <div class="grid grid-products">
                    @foreach($data['computers'] as $product)
                    @include('site.card', compact('product'))
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
<div class="wrapper">
    <div class="container">
        <div class="row">
            <div id="carousel-best" class="col-12">
                <h2 class="section-title">
                    Impresoras
                    <div class="section-message">
                        Impresoras a la medida de tu negocio.
                    </div>
                </h2>
                <div class="grid grid-products">
                    @foreach($data['printers'] as $product)
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
            <div id="carousel-best" class="col-12">
                <h2 class="section-title">
                    Accesorios
                    <div class="section-message">
                        Los mejores aliados para tu tecnología
                    </div>
                </h2>
                <div class="grid grid-products">
                    @foreach($data['devices'] as $product)
                    @include('site.card', compact('product'))
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
<div class="wrapper">
    <div class="container">
        <div class="row row-services">
            <div class="col-md-4 mb-3">
                <div class="card card-simple">
                    <div class="position-relative">
                        <div class="img-container">
                            <img src="images/tecnologia.webp" class="img-cover img-loading" alt="gama de productos" width="340" height="226" loading="lazy"/>
                        </div>
                        <span class="badge-card badge bg-warning">
                            <i class="fal fa-badge-check"></i>
                            Gama alta de productos
                        </span>
                    </div>
                    <div class="card-body text-white bg-secondary">
                        <p class="fw-light">
                            Ofrecemos productos recientes y avanzados en tecnología de cómputo, como laptops con los últimos procesadores, tarjetas gráficas de alto rendimiento y periféricos innovadores.
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card card-simple">
                    <div class="position-relative">
                        <div class="img-container">
                            <img src="images/servicios.webp" class="img-cover img-loading" alt="soluciones de cómputo" width="340" height="226" loading="lazy"/>
                        </div>
                        <span class="badge-card badge bg-warning">
                            <i class="fal fa-badge-check"></i>
                            Soluciones personalizadas de cómputo
                        </span>
                    </div>
                    <div class="card-body text-white bg-secondary">
                        <p class="fw-light">
                            Nuestros servicios permiten a los clientes personalizar y configurar sus equipos según sus necesidades, desde la construcción de PCs hasta la instalación de software y hardware.
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card card-simple">
                    <div class="position-relative">
                        <div class="img-container">
                            <img src="images/cotizaciones.webp" class="img-cover img-loading" alt="cotizaciones a medida" width="340" height="226" loading="lazy"/>
                        </div>
                        <span class="badge-card badge bg-warning">
                            <i class="fal fa-badge-check"></i>
                            Cotizaciones a tu medida
                        </span>
                    </div>
                    <div class="card-body text-white bg-secondary">
                        <p class="fw-light">
                            Descubre lo fácil que es crear tus propias cotizaciones. Ajusta cada detalle y cada producto según tus necesidades específicas, para obtener beneficios y precios adaptados al instante.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="wrapper bg-light">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <h2 class="section-title">
                    Nosotros
                    <div class="section-message">
                        Comprometidos con la excelencia en tecnología.
                    </div>
                </h2>
                <div class="fw-normal mb-2">
                    MCA Soluciones es una empresa Oaxaqueña con 30 años de experiencia en la implementación de tecnologías de la información en los sectores público, privado y empresarial. Nuestro compromiso es ofrecer soluciones integrales que se adapten a las necesidades de nuestros clientes. Contamos con un equipo de expertos en tecnologías que brindan asesoría continua en cada proyecto, asegurando que se cumplan los más altos estándares de calidad. Además, disponemos de la infraestructura necesaria para respaldar nuestro servicio.
                </div>
            </div>
            <div class="col-md-4">
                <div class="img-container rounded-4">
                    <img src="images/building.webp" class="img-loading img-fluid" alt="soluciones" width="1090" height="300" loading="lazy"/>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('[id^="click-cart-add-"]').forEach(function (el) {
            el.addEventListener('click', function (event) {
                const sku = this.dataset.sku;
                const name = this.dataset.name;
                const price = parseFloat(this.dataset.price);
                const quantity = parseInt(this.dataset.extra);
                gtag('event', 'add_to_cart', {
                    currency: 'MXN',
                    value: price * quantity,
                    items: [{
                        item_id: sku,
                        item_name: name,
                        price: price,
                        quantity: quantity
                    }]
                });
            });
        });
    });
</script>
@endsection
