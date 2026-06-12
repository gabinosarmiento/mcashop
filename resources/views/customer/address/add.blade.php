<div class="overlap-wrap-xs">
    <div class="overlap-header">
        <div class="overlap-close"></div>
        Agregar
    </div>
    <div class="overlap-body">
        <form id="submit-address-form" data-method="post" data-route="guardar" data-overlap-hide="#overlap-one">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">
                    Nombre
                    <span class="required"></span>
                </label>
                <input type="text" name="name" class="form-control"/>
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
                <input type="email" name="email" class="form-control"/>
            </div>
            <div class="mb-3">
                <label for="street" class="form-label">
                    Calle, número
                    <span data-wenk="Calle, número interior y/o exterior">
                        <i class="fal fa-circle-info"></i>
                    </span>
                    <span class="required"></span>
                </label>
                <input type="text" name="street" class="form-control"/>
            </div>
            <div class="mb-3">
                <label for="streets" class="form-label">
                    Entrecalles
                    <span data-wenk="Entre qué calles">
                        <i class="fal fa-circle-info"></i>
                    </span>
                    <span class="required"></span>
                </label>
                <input type="text" name="streets" class="form-control"/>
            </div>
            <div class="mb-3">
                <label for="reference" class="form-label">
                    Referencia
                </label>
                <input type="text" name="reference" class="form-control"/>
            </div>
            <div class="mb-3">
                <label for="zc" class="form-label">
                    Código postal
                    <span class="required"></span>
                </label>
                <input type="text" id="change-zc" name="zc" class="form-control" data-route="ubicacion"/>
            </div>
            <fieldset id="location-html">
                <div class="mb-3">
                    <label for="colony" class="form-label">
                        Colonia
                        <span class="required"></span>
                    </label>
                    <input type="text" name="colony" class="form-control" readonly/>
                </div>
                <div class="mb-3">
                    <label for="city" class="form-label">
                        Ciudad
                        <span class="required"></span>
                    </label>
                    <input type="text" name="city" class="form-control" readonly/>
                </div>
                <div class="mb-3">
                    <label for="state" class="form-label">
                        Estado
                        <span class="required"></span>
                    </label>
                    <input type="text" name="state" class="form-control" readonly/>
                </div>
                <div class="mb-3">
                    <label for="country" class="form-label">
                        País
                        <span class="required"></span>
                    </label>
                    <input type="text" name="country" class="form-control" value="México" readonly/>
                </div>
            </fieldset>
            <div class="text-end">
                <button type="submit" class="btn btn-subtle-flat">
                    <i class="fal fa-check"></i>
                    Guardar
                </button>
            </div>
        </form>
    </div>
</div>
