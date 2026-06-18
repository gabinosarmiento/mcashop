@include('store.order')
<nav class="sidebar-nav">
    <ul class="list-unstyled" id="category-sidebar">
        @foreach($data['filters'] as $filter)
        <li class="sidebar-item">
            <span class="sidebar-link sidebar-caret" data-bs-target="#submenu-{{ $filter['id'] }}" data-bs-toggle="collapse">
                {{ $filter['name'] }}
                @if($filter['count'])
                <small class="d-inline text-danger text-nowrap">
                    [ {{ $filter['count'] }} ]
                </small>
                @endif
            </span>
            <ul class="sidebar-submenu list-unstyled collapse" data-bs-parent="#category-sidebar" id="submenu-{{ $filter['id'] }}">
                @foreach($filter['submenu'] as $submenu)
                <li class="sidebar-sublink">
                    <div class="form-check mb-0">
                        <input class="form-check-input" id="filter-{{ $prefix }}-{{ $loop->iteration }}-{{ $filter['id'] }}" name="filter[{{ $filter['id'] }}][]" type="checkbox" value="{{ $submenu['value'] }}" @checked($submenu['checked'])>
                        <label class="form-check-label" for="filter-{{ $prefix }}-{{ $loop->iteration }}-{{ $filter['id'] }}">
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