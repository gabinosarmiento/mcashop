@extends('layouts.site')
@section('title', "MCAShop - {$data['name']}")
@section('description', "En esta sección encontrarás solo lo mejor en productos {$data['name']}")
@section('mobile')
<div class="offcanvas offcanvas-start" tabindex="-1" id="mobile-sidebar">
    <div class="offcanvas-header">
        <a href="{{ route('inicio') }}">
            <img src="{{ asset('images/logo.svg') }}" class="logo" alt="mcashop" width="135">
        </a>
        <button type="button" class="btn-close position-absolute end-0 me-3" data-bs-dismiss="offcanvas"></button>
    </div>
    <div class="offcanvas-body">
        <form id="submit-mobile-filter" data-action="{{ route($source, [$data['id'], str($data['name'])->slug()]) }}">
            @include('partials.filters', ['prefix' => 'mobile'])
        </form>
    </div>
</div>
@endsection
@section('content')
<div class="container">
    {{ Breadcrumbs::render($source, $data) }}
    <div class="layout-mca">
        <aside class="sidebar-mca d-none d-lg-block">
            <form id="submit-filter" data-action="{{ route($source, [$data['id'], str($data['name'])->slug()]) }}">
                @include('partials.filters', ['prefix' => 'desktop'])
            </form>
        </aside>
        <section class="content-mca">
            <div class="grid grid-section mb-4">
                @foreach($data['data'] as $product)
                    @include('store.card', compact('product'))
                @endforeach
            </div>
            @include('store.pagination')
        </section>
    </div>
</div>
<script>
    document.addEventListener('click', function (e) {
    const btn = e.target.closest('[id^="click-cart-add-"]');
    if (btn) {
        gtag('event', 'add_to_cart', {
            currency: 'MXN',
            value: parseFloat(btn.dataset.price),
            items: [{
                item_id: btn.dataset.sku,
                item_name: btn.dataset.name,
                price: parseFloat(btn.dataset.price),
                quantity: 1
            }]
        });
    }
});
</script>
@endsection