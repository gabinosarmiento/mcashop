<ul class="nav nav-pills justify-content-end mb-2">
    <li class="nav-item">
        <button class="nav-link active" data-bs-toggle="pill" data-bs-target="#product-tab" data-wenk="Producto">
            <i class="fal fa-circle-info"></i>
        </button>
    </li>
    <li class="nav-item">
        <button class="nav-link" data-bs-toggle="pill" data-bs-target="#features-tab" data-wenk="Características">
            <i class="fal fa-clipboard-list"></i>
        </button>
    </li>
    <li class="nav-item">
        <button class="nav-link" data-bs-toggle="pill" data-bs-target="#search-tab" data-wenk="Referencias">
            <i class="fal fa-magnifying-glass"></i>
        </button>
    </li>
    <li class="nav-item">
        <button class="nav-link" data-bs-toggle="pill" data-bs-target="#health-tab" data-wenk="Salud">
            <i class="fal fa-heart-pulse"></i>
        </button>
    </li>
    <li class="nav-item">
        <button class="nav-link" data-bs-toggle="pill" data-bs-target="#relations-tab" data-wenk="Relaciones">
            <i class="fal fa-link"></i>
        </button>
    </li>
    <li class="nav-item">
        <button class="nav-link" data-bs-toggle="pill" data-bs-target="#images-tab" data-wenk="Imágenes">
            <i class="fal fa-file-image"></i>
        </button>
    </li>
    <li class="nav-item dropdown">
        <button class="nav-link text-mca" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fal fa-circle-ellipsis"></i>
        </button>
        <ul class="dropdown-menu">
            <li>
                <button class="dropdown-item" id="action-product-edit-{{ $data['id'] }}" data-route="editar?{{ request()->withQuery(['id' =>$data['id']]) }}" data-overlap-show="#overapp">
                    <i class="fal fa-pen"></i>
                    Editar
                </button>
            </li>
            <li>
                <button class="dropdown-item" id="action-product-publish-{{ $data['id'] }}" data-route="publicar?{{ request()->withQuery(['id' =>$data['id']]) }}" data-overlap-hide="#overapp">
                    <i class="fal fa-store"></i>
                    Publicar
                </button>
            </li>
            <li>
                <button class="dropdown-item dropdown-item-primary" id="action-product-icecat-{{ $data['id'] }}" data-route="icecat?{{ request()->withQuery(['id' =>$data['id']]) }}" data-overlap-hide="#overapp">
                    <i class="fal fa-cube"></i>
                    Icecat
                </button>
            </li>
            <li>
                <button class="dropdown-item dropdown-item-warning" id="action-product-block-{{ $data['id'] }}" data-route="bloquear?{{ request()->withQuery(['id' =>$data['id']]) }}" data-overlap-hide="#overapp">
                    <i class="fal fa-ban"></i>
                    Bloquear
                </button>
            </li>
            <li>
                <button class="dropdown-item dropdown-item-danger" id="delete-product-{{ $data['id'] }}" data-route="eliminar?{{ request()->withQuery(['id' =>$data['id']]) }}" data-overlap-hide="#overapp">
                    <i class="fal fa-trash-can"></i>
                    Eliminar
                </button>
            </li>
        </ul>
    </li>
</ul>