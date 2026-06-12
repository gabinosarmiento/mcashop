<div class="overlap-wrap-xs">
    <div class="overlap-header">
        <div class="overlap-close"></div>
        Agregar
    </div>
    <div class="overlap-body">
        <form id="submit-billing-form" data-method="post" data-route="guardar" data-overlap-hide="#overlap-one">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">
                    Nombre
                    <span class="required"></span>
                </label>
                <input type="text" name="name" class="form-control"/>
            </div>
            <div class="mb-3">
                <label for="rfc" class="form-label">
                    RFC
                    <span data-wenk="Mayúsculas">
                        <i class="fal fa-circle-info"></i>
                    </span>
                    <span class="required"></span>
                </label>
                <input type="text" name="rfc" class="form-control text-uppercase"/>
            </div>
            <div class="mb-3">
                <label for="regime" class="form-label">
                    Régimen
                    <span class="required"></span>
                </label>
                <select name="regime" class="form-select">
                    <option value="">
                        Seleccionar una opción
                    </option>
                    @foreach(REGIME as $id => $regime)
                    <option value="{{ $id }}">
                        {{ $regime }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="phone" class="form-label">
                    Teléfono
                    <span class="required"></span>
                </label>
                <input type="tel" name="phone" class="form-control"/>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">
                    Correo electrónico
                    <span class="required"></span>
                </label>
                <input type="text" name="email" class="form-control"/>
            </div>
            <div class="mb-3">
                <label for="zc" class="form-label">
                    Código postal
                    <span class="required"></span>
                </label>
                <input type="text" name="zc" class="form-control"/>
            </div>
            <div class="text-end">
                <button type="submit" class="btn btn-subtle-flat">
                    <i class="fal fa-check"></i>
                    Guardar
                </button>
            </div>
        </form>
    </div>
</div>