<div class="overlap-wrap-xs">
    <div class="overlap-header">
        <div class="overlap-close"></div>
        Agregar
    </div>
    <div class="overlap-body">
        <form id="ajax-administrative-form" data-method="post" data-route="guardar"data-overlap-hide="#overapp">
            @csrf
            <div class="mb-2">
                <label for="firstname" class="form-label">
                    Nombre
                    <span class="required"></span>
                </label>
                <input type="text" name="firstname" id="firstname" class="form-control"/>
            </div>
            <div class="mb-2">
                <label for="lastname" class="form-label">
                    Apellido
                    <span class="required"></span>
                </label>
                <input type="text" name="lastname" id="lastname" class="form-control"/>
            </div>
            <div class="mb-2">
                <label for="department" class="form-label">
                    Departamento
                    <span class="required"></span>
                </label>
                <select name="department" id="department" class="form-select">
                    <option value="">
                        Seleccionar una opción
                    </option>
                    @foreach(DEPARTMENT as $department)
                    <option value="{{ $department }}">
                        {{ $department }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="mb-2">
                <label for="email" class="form-label">
                    Correo electrónico
                    <span class="required"></span>
                </label>
                <input type="email" name="email" id="email" class="form-control"/>
            </div>
            <div class="mb-2">
                <label for="password" class="form-label">
                    Contraseña
                </label>
                <input type="password" name="password" id="password" class="form-control"/>
            </div>
            <div class="mb-2">
                <label for="status" class="form-label">
                    Estatus
                    <span class="required"></span>
                </label>
                <select name="status" id="status" class="form-select">
                    <option value="Activo">
                        Activo
                    </option>
                    <option value="Cancelado">
                        Cancelado
                    </option>
                </select>
            </div>
            <button type="submit" class="btn btn-light">
                Guardar
            </button>
        </form>
    </div>
</div>
