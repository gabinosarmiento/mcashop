<div class="overlap-wrap-sm">
    <div class="overlap-header">
        <div class="overlap-close"></div>
        Editar
    </div>
    <div class="overlap-body">
        <form id="ajax-customer-form" data-route="actualizar" data-method="post" data-overlap-hide="#overlap-one">
            @csrf
            <input type="hidden" name="id" value="{{ $data['id'] }}"/>
            <div class="mb-2">
                <label for="firstname" class="form-label">
                    Nombre
                    <span class="required"></span>
                </label>
                <input type="text" id="firstname" name="firstname" class="form-control" value="{{ $data['firstname'] }}"/>
            </div>
            <div class="mb-2">
                <label for="lastname" class="form-label">
                    Apellido
                    <span class="required"></span>
                </label>
                <input type="text" id="lastname" name="lastname" class="form-control" value="{{ $data['lastname'] }}"/>
            </div>
            <div class="mb-2">
                <label for="phone" class="form-label">
                    Teléfono
                    <span class="required"></span>
                </label>
                <input type="tel" id="phone" name="phone" class="form-control" value="{{ $data['phone'] }}"/>
            </div>
            <button type="submit" class="btn btn-outline-mca">
                Actualizar
            </button>
        </form>
    </div>
</div>