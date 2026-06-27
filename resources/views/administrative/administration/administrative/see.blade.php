<div class="overlap-wrap-xs">
    <div class="overlap-header">
        <div class="overlap-close"></div>
        Administrativo
    </div>
    <div class="overlap-body">
        <ul class="nav nav-pills justify-content-end mb-2">
            <li class="nav-item">
                <button class="nav-link active" data-bs-toggle="pill" data-bs-target="#administrative-tab" data-wenk="Administrativo">
                    <i class="fal fa-user-tie"></i>
                </button>
            </li>
            <li class="nav-item">
                <button class="nav-link" data-bs-toggle="pill" data-bs-target="#modules-tab" data-wenk="Módulos">
                    <i class="fal fa-gear-complex"></i>
                </button>
            </li>
            <li class="nav-item dropdown">
                <button class="nav-link" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fal fa-circle-ellipsis"></i>
                </button>
                <ul class="dropdown-menu">
                    <li>
                        <button class="dropdown-item" id="action-administrative-edit-{{ $data['id'] }}" data-route="editar?{{ request()->withQuery(['id' => $data['id']]) }}" data-overlap-show="#overapp">
                            <i class="fal fa-pen"></i>
                            Editar
                        </button>
                    </li>
                    <li>
                        <button class="dropdown-item dropdown-item-danger" id="delete-administrative-{{ $data['id'] }}" data-route="eliminar?{{ request()->withQuery(['id' => $data['id']]) }}" data-overlap-hide="#overapp">
                            <i class="fal fa-trash-can"></i>
                            Eliminar
                        </button>
                    </li>
                </ul>
            </li>
        </ul>
        <div class="row">
            <div class="col-auto">
                <div id="image-html">
                    @include('administrative.image')
                </div>
            </div>
            <div class="col">
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="administrative-tab">
                        <table class="table table-sm table-borderless">
                            <tr>
                                <th width="120">
                                    Id
                                </th>
                                <td>
                                    {{ $data['id'] }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Nombre
                                </th>
                                <td>
                                    {{ $data['firstname'] }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Apellido
                                </th>
                                <td>
                                    {{ $data['lastname'] }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Departamento
                                </th>
                                <td>
                                    {{ $data['department'] }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Correo
                                </th>
                                <td>
                                    {{ $data['email'] }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Creado
                                </th>
                                <td>
                                    {{ $data['created_at'] }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Actualizado
                                </th>
                                <td>
                                    {{ $data['updated_at'] }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Estatus
                                </th>
                                <th class="{{ $data['status'] }}">
                                    {{ $data['status'] }}
                                </th>
                            </tr>
                        </table>
                    </div>
                    <div class="tab-pane fade" id="modules-tab">
                        <div class="d-flex flex-column gap-2">
                            <form id="ajax-administrative-module-form" data-method="post" data-route="modulo/guardar">
                                @csrf
                                <input type="hidden" name="administrative_id" value="{{ $data['id'] }}"/>
                                <div class="input-group">
                                    <select name="module" class="form-select">
                                        <option value="">
                                            Módulo
                                        </option>
                                        @foreach(MODULE as $id => $module)
                                        <option value="{{ $id }}">
                                            {{ $module }}
                                        </option>
                                        @endforeach
                                    </select>
                                    <button type="submit" class="btn btn-secondary">
                                        <i class="fal fa-plus"></i>
                                    </button>
                                </div>
                            </form>
                            <div id="modules">
                                @include('administrative.administration.administrative.modules')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
