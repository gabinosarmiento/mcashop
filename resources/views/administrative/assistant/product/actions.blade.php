<div class="d-flex justify-content-end gap-2">
    <div class="dropdown">
        <button id="config-dropdown" type="button" class="btn btn-outline-secondary" data-bs-toggle="dropdown" aria-expanded="false" data-wenk="Registros">
            <i class="fal fa-gear-complex"></i>
        </button>
        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="config-dropdown">
            <li>
                <button type="button" class="dropdown-item">
                    Todos
                </button>
            </li>
            <li>
                <button type="button" class="dropdown-item">
                    Activos
                </button>
            </li>
            <li>
                <button type="button" class="dropdown-item">
                    Pausados
                </button>
            </li>
            <li>
                <button type="button" class="dropdown-item">
                    Borradores
                </button>
            </li>
            <li>
                <button type="button" class="dropdown-item">
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
