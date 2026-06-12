@extends('layouts.site')
@section('title', "MCAShop - {$data['brand']['name']}")
@section('description', str($data['brand']['description'])->limit(150))
@section('content')
<div class="container">
    {{ Breadcrumbs::render('marca', $data['brand']) }}
    <div class="layout-mca">
        <div class="sidebar-mca">
            <form data-action="{{ route('marca', [$data['brand']['id'], str($data['brand']['name'])->slug()]) }}" data-method="get" id="filter-brand-form">
                @include('store.order')
                <nav class="sidebar-nav">
                    <ul class="list-unstyled" id="sidebar">
                        @foreach($data['filter'] as $filter)
                        @php($count = count($data['categories'] ?? []))
                        <li class="sidebar-item">
                            <span class="sidebar-link sidebar-caret" data-bs-target="#submenu-{{ $filter['id'] }}" data-bs-toggle="collapse">
                                {{ $filter['name'] }}
                                @if($count > 0)
                                <small class="d-inline text-danger text-nowrap">
                                    [ {{ $count }} ]
                                </small>
                                @endif
                            </span>
                            <ul class="sidebar-submenu list-unstyled collapse" data-bs-parent="#sidebar" id="submenu-{{ $filter['id'] }}">
                                @foreach($filter['submenu'] as $submenu)
                                <li class="sidebar-sublink">
                                    <div class="form-check">
                                        <input class="form-check-input" id="filter-{{ $loop->iteration }}-{{ $filter['id'] }}" name="categories[]" type="checkbox" value="{{ $submenu['id'] }}" @checked(in_array($submenu['id'], $data['categories'] ?? []))>
                                            <label class="form-check-label" for="filter-{{ $loop->iteration }}-{{ $filter['id'] }}">
                                                {{ $submenu['value'] }}
                                            </label>
                                        </input>
                                    </div>
                                </li>
                                @endforeach
                            </ul>
                        </li>
                        @endforeach
                    </ul>
                </nav>
            </form>
        </div>
        <div class="content-mca">
            <div class="grid grid-section mb-4">
                @foreach($data['data'] as $product)
                @include('store.card', compact('product'))
                @endforeach
            </div>
            @include('store.pagination')
        </div>
    </div>
</div>
<script>
    document.addEventListener('click', function (e) {
        const btn = e.target.closest('[id^="click-cart-add-"]');
        if (btn) {
            const sku = btn.dataset.sku;
            const name = btn.dataset.name;
            const price = parseFloat(btn.dataset.price);
            const quantity = parseInt(btn.dataset.extra);

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
        }
    });
</script>
@endsection
