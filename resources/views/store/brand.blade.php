@extends('layouts.site')
@section('title', "MCAShop - {$data['brand']['name']}")
@section('description', str($data['brand']['description'])->limit(150))
@section('mobile')
<div id="overlap-sidebar" class="overlap">
   <div class="overlap-wrap overlap-wrap-sm">
      <div class="overlap-header">
         <div class="overlap-close"></div>
         Filtro
      </div>
      <div class="overlap-body">
         <form id="filter-brand-form" data-method="get" data-action="{{ route('marca', [$data['brand']['id'], str($data['brand']['name'])->slug()]) }}">
            <nav class="sidebar-nav">
               <ul class="list-unstyled" id="parent-root">
                  @foreach($data['filter'] as $filter)
                  @php($count = isset($data['categories']) ? count($data['categories']) : 0)
                  <li class="sidebar-item">
                     <span class="font-weight-bold sidebar-link sidebar-caret" data-bs-toggle="collapse" data-target="#submenu-{{ $filter['id'] }}" aria-expanded="false">
                        {{ $filter['name'] }}
                        @if($count > 0)
                        <small class="d-inline text-danger text-nowrap">
                           [ {{ $count }} ]
                        </small>
                        @endif
                     </span>
                     <ul class="sidebar-submenu list-unstyled collapse" id="submenu-{{ $filter['id'] }}" data-parent="#parent-root">
                        @foreach($filter['submenu'] as $submenu)
                        @php($checked = in_array($filter['id'], $data['categories'] ?? []) ? 'checked' : '')
                        <li class="sidebar-sublink">
                           <div class="custom-control custom-checkbox">
                              <input type="checkbox" id="filter-{{ $loop->iteration }}:{{ $filter['id'] }}" name="categories[]" value="{{ $submenu['id'] }}" class="custom-control-input" {{ $checked }}/>
                              <label class="custom-control-label">
                                 {{ $submenu['value'] }}
                              </label>
                           </div>
                        </li>
                        @endforeach
                     </ul>
                  </li>
                  @endforeach
               </ul>
            </nav>
            @include('store.order')
         </form>
      </div>
   </div>
</div>
@endsection
@section('content')
<div class="container">
   {{ Breadcrumbs::render('marca', $data['brand']) }}
   <div class="layout-mca">
      <div class="sidebar-mca">
         <form id="filter-brand-form" data-method="get" data-action="{{ route('marca', [$data['brand']['id'], str($data['brand']['name'])->slug()]) }}">
            @include('store.order')
            <nav id="sidebar" class="sidebar-nav">
               <ul class="list-unstyled">
                  @foreach($data['filter'] as $filter)
                  @php($count = isset($data['categories']) ? count($data['categories']) : 0)
                  <li class="sidebar-item">
                     <span class="sidebar-link sidebar-caret" data-bs-toggle="collapse" data-target="#submenu-{{ $filter['id'] }}">
                        {{ $filter['name'] }}
                        @if($count > 0)
                        <small class="d-inline text-danger text-nowrap">
                           [ {{ $count }} ]
                        </small>
                        @endif
                     </span>
                     <ul class="sidebar-submenu list-unstyled collapse" id="submenu-{{ $filter['id'] }}" data-bs-parent="#sidebar">
                        @foreach($filter['submenu'] as $submenu)
                        @php($checked = in_array($submenu['id'], $data['categories'] ?? []) ? 'checked' : '')
                        <li class="sidebar-sublink">
                           <div class="form-check">
                              <input type="checkbox" id="filter-{{ $loop->iteration }}-{{ $filter['id'] }}" name="categories[]" value="{{ $submenu['id'] }}" class="form-check-input" {{ $checked }}/>
                              <label class="form-check-label" for="filter-{{ $loop->iteration }}-{{ $filter['id'] }}">
                                 {{ $submenu['value'] }}
                              </label>
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
         <div class="grid">
            @foreach($data['data'] as $product)
            @include('store.card', compact('product'))
            @endforeach
         </div>
         <div class="section-pagination">
            @include('store.pagination')
         </div>
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
