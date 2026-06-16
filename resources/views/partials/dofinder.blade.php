<div id="dofinder-modal" class="dofinder-container">
    <div class="dofinder-progress">
        <div class="dofinder-progress-bar"></div>
    </div>
    <div class="dofinder-header">
        <button type="button" class="dofinder-close">
            &times;
        </button>
    </div>
    <div class="dofinder-body">
        <div class="dofinder-inner">
            <div id="layout-dofinder">
                <div id="dofinder-sidebar">
                    <div class="dofinder-title">
                        <i class="fal fa-bars-filter"></i>
                        Filtros
                    </div>
                    <form id="dofilter-form">
                        <select name="order" class="form-select form-select-sm mb-2">
                            <option selected disabled>
                                Orden
                            </option>
                            <option value="asc">
                                Nombre a ~ z
                            </option>
                            <option value="desc">
                                Nombre z ~ a
                            </option>
                            <option value="low">
                                Precio mínimo
                            </option>
                            <option value="high">
                                Precio máximo
                            </option>
                        </select>
                        <nav class="sidebar-nav">
                            <ul class="list-unstyled" id="dofilter-sidebar">
                                @foreach($data['filter'] as $filter)
                                <li class="sidebar-item">
                                    <span class="sidebar-link sidebar-link-sm sidebar-caret" data-bs-target="#dofilter-submenu-{{ $filter['id'] }}" data-bs-toggle="collapse">
                                        {{ $filter['name'] }}
                                    </span>
                                    <ul class="sidebar-submenu list-unstyled collapse" id="dofilter-submenu-{{ $filter['id'] }}" data-bs-parent="#dofilter-sidebar">
                                        @foreach($filter['submenu'] as $submenu)
                                        <li class="sidebar-sublink sidebar-sublink-sm">
                                            <div class="form-check">
                                                <input class="form-check-input" id="dofilter-{{ $loop->iteration }}-{{ $filter['id'] }}" name="filters[{{ $filter['id'] }}][]" type="checkbox" value="{{ $submenu['value'] }}">
                                                <label class="form-check-label" for="dofilter-{{ $loop->iteration }}-{{ $filter['id'] }}">
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
                <div id="dofinder-content">
                    @include('partials.doinner')
                </div>
            </div>
        </div>
    </div>
    <div class="dofinder-footer"></div>
</div>
