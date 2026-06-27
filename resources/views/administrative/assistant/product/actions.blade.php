<div class="d-flex justify-content-end gap-2">
    <div class="dropdown">
        <button id="config-dropdown" class="btn btn-outline-secondary" data-bs-toggle="dropdown" aria-expanded="false" data-wenk="Registros">
            <i class="fal fa-gear-complex"></i>
        </button>
        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="config-dropdown" data-bs-selectable="true">
            <li>
                <button class="dropdown-item" id="action-product-all" data-route="registros">
                    Todos
                </button>
            </li>
            <li>
                <button class="dropdown-item" id="action-product-active" data-route="registros?{{ request()->withQuery(['status' => 'Activo']) }}">
                    Activos
                </button>
            </li>
            <li>
                <button class="dropdown-item" id="action-product-paused" data-route="registros?{{ request()->withQuery(['status' => 'Pausado']) }}">
                    Pausados
                </button>
            </li>
            <li>
                <button class="dropdown-item" id="action-product-draft" data-route="registros?{{ request()->withQuery(['status' => 'Borrador']) }}">
                    Borradores
                </button>
            </li>
            <li>
                <button class="dropdown-item" id="action-product-canceled" data-route="registros?{{ request()->withQuery(['status' => 'Cancelado']) }}">
                    Cancelados
                </button>
            </li>
        </ul>
    </div>
    <button id="click-duplicate-product" data-route="duplicados?{{ request()->withQuery() }}" data-overlap-show="#overapp" class="btn btn-outline-secondary" data-wenk="Duplicados">
        <i class="fal fa-clone"></i>
    </button>
    <button id="click-lock-product" data-route="bloquear?{{ request()->withQuery() }}" data-overlap-show="#overapp" class="btn btn-outline-secondary" data-wenk="Bloquear">
        <i class="fal fa-ban"></i>
    </button>
    <button id="action-product-add" data-route="agregar" data-overlap-show="#overapp" class="btn btn-outline-secondary" data-wenk="Agregar">
        <i class="fal fa-plus"></i>
    </button>
</div>
