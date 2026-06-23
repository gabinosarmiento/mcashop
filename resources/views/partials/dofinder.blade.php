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
        <div class="dofinder-wrap">
            <div class="dofinder-sidebar">
                <div class="dofinder-title">
                    <i class="fal fa-bars-filter"></i>
                    Filtros
                </div>
                <aside class="sidebar-mca">
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
                        <nav class="dofinder-nav">
                            <ul class="list-unstyled" id="dofinder-sidebar">
                                @foreach($data['filters'] as $filter)
                                <li class="dofinder-item">
                                    <span class="dofinder-link dofinder-caret" data-bs-target="#dofinder-submenu-{{ $filter['id'] }}" data-bs-toggle="collapse">
                                        {{ $filter['name'] }}
                                    </span>
                                    <ul class="dofinder-submenu collapse" id="dofinder-submenu-{{ $filter['id'] }}" data-bs-parent="#dofinder-sidebar">
                                        @foreach($filter['submenu'] as $submenu)
                                        <li class="dofinder-sublink">
                                            <div class="form-check mb-0">
                                                <input class="form-check-input" id="dofinder-{{ $loop->iteration }}-{{ $filter['id'] }}" name="filters[{{ $filter['id'] }}][]" type="checkbox" value="{{ $submenu['value'] }}">
                                                <label class="form-check-label" for="dofinder-{{ $loop->iteration }}-{{ $filter['id'] }}">
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
                </aside>
            </div>
            <div class="dofinder-content">
                @include('partials.dofinderitem')
            </div>
        </div>
    </div>
    <div class="dofinder-footer"></div>
</div>
