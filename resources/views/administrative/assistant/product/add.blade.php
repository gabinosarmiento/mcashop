<div class="overlap-wrap-sm">
    <div class="overlap-header">
        <div class="overlap-close"></div>
        Agregar
    </div>
    <div class="overlap-body">
        <form id="ajax-product-form" data-method="post" data-route="guardar" data-overlap-hide="#overapp">
            @csrf
            <div class="mb-2">
                <label class="form-label" for="brand_name">
                    Marca
                    <span class="required"></span>
                </label>
                <input id="brand_id" name="brand_id" type="hidden"/>
                <input class="form-control" id="brand_name" name="brand_name" type="text"/>
            </div>
            <div class="mb-2">
                <label class="form-label" for="category_name">
                    Categoría
                </label>
                <input id="category_id" name="category_id" type="hidden"/>
                <input class="form-control" id="category_name" name="category_name" type="text"/>
            </div>
            <div class="mb-2">
                <label class="form-label" for="sku">
                    Sku
                    <span class="required"></span>
                </label>
                <input class="form-control" id="sku" name="sku" type="text"/>
            </div>
            <div class="mb-2">
                <label class="form-label" for="name">
                    Nombre
                    <span class="required"></span>
                </label>
                <input class="form-control" id="name" name="name" type="text"/>
            </div>
            <div class="mb-2">
                <label class="form-label" for="subname">
                    Subnombre
                </label>
                <input class="form-control" id="subname" name="subname" type="text"/>
            </div>
            <div class="mb-2">
                <label class="form-label" for="review">
                    Resumen
                </label>
                <input class="form-control" id="review" name="review" type="text"/>
            </div>
            <div class="mb-2">
                <label class="form-label" for="description">
                    Descripción
                </label>
                <input class="form-control" id="description" name="description" type="text"/>
            </div>
            <div class="mb-2">
                <label class="form-label" for="gtin">
                    Gtin
                </label>
                <input class="form-control" id="gtin" name="gtin" type="text"/>
            </div>
            <div class="mb-2">
                <label class="form-label" for="weight">
                    Peso
                    <span data-wenk="Kilogramos">
                        <i class="fal fa-circle-info"></i>
                    </span>
                </label>
                <input class="form-control" id="weight" name="weight" type="text"/>
            </div>
            <div class="mb-2">
                <label class="form-label" for="note">
                    Nota
                </label>
                <input class="form-control" id="note" name="note" type="text"/>
            </div>
            <div class="mb-3">
                <label class="form-label" for="status">
                    Estatus
                    <span class="required"></span>
                </label>
                <select class="form-select" id="status" name="status">
                    <option value="Borrador">
                        Borrador
                    </option>
                </select>
            </div>
            <button class="btn btn-outline-secondary" type="submit">
                Guardar
            </button>
        </form>
    </div>
</div>
<script>
    flatcomplete("#brand_name", {
        url: "marcas",
        key: "id",
        value: "name",
        onSelect: function(item) {
            document.querySelector("#brand_id").value = item.id;
        }
    });

    flatcomplete("#category_name", {
        url: "categorias",
        key: "id",
        value: "name",
        onSelect: function(item) {
            document.querySelector("#category_id").value = item.id;
        }
    });
</script>
