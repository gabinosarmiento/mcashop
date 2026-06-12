<div class="overlap-wrap-xs">
    <div class="overlap-header">
        <div class="overlap-close"></div>
        Editar
    </div>
    <div class="overlap-body">
        <form id="submit-billing-form" data-method="post" data-route="actualizar" data-overlap-hide="#overlap-one">
            @csrf
            <input type="hidden" name="id" value="{{ $data['id'] }}"/>
            <div class="mb-3">
                <label for="name" class="form-label">
                    Nombre
                    <span class="required"></span>
                </label>
                <input type="text" name="name" class="form-control" value="{{ $data['name'] }}"/>
            </div>
            <div class="mb-3">
                <label for="rfc" class="form-label">
                    RFC
                    <span data-wenk="Mayúsculas">
                        <i class="fal fa-circle-info"></i>
                    </span>
                    <span class="required"></span>
                </label>
                <input type="text" name="rfc" class="form-control text-uppercase" value="{{ $data['rfc'] }}"/>
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
                    <option value="{{ $id }}" @selected($data['regime'] == $id)>
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
                <input type="tel" name="phone" class="form-control" value="{{ $data['phone'] }}"/>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">
                    Correo electrónico
                    <span class="required"></span>
                </label>
                <input type="email" name="email" class="form-control" value="{{ $data['email'] }}"/>
            </div>
            <div class="mb-3">
                <label for="zc" class="form-label">
                    Código postal
                    <span class="required"></span>
                </label>
                <input type="text" name="zc" class="form-control" value="{{ $data['zc'] }}"/>
            </div>
            <div class="text-end">
                <button type="submit" class="btn btn-subtle-flat">
                    <i class="fal fa-check"></i>
                    Actualizar
                </button>
            </div>
        </form>
    </div>
</div>
