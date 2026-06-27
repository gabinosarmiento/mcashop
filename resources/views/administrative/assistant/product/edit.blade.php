<div class="overlap-wrap-sm">
    <div class="overlap-header">
        <div class="overlap-close"></div>
        Editar
    </div>
    <div class="overlap-body">
        <form id="ajax-product-form" data-method="post" data-route="actualizar?{{ request()->withQuery() }}" data-overlap-hide="#overapp">
            @csrf
            <input type="hidden" name="id" value="{{ $data['id'] }}"/>
            <div class="mb-2">
                <label class="form-label" for="brand_name">
                    Marca
                    <span class="required"></span>
                </label>
                <input type="hidden" id="brand_id" name="brand_id" value="{{ $data['brand_id'] }}"/>
                <input class="form-control" id="brand_name" name="brand_name" type="text" value="{{ $data['brand']['name'] }}"/>
            </div>
            <div class="mb-2">
                <label for="category-name" class="form-label">
                    Categoría
                </label>
                <input type="hidden" id="category_id" name="category_id" value="{{ $data['category_id'] }}"/>
                <input type="text" id="category-name" name="category-name" class="form-control" value="{{ $data['category']['name'] }}"/>
            </div>
            <div class="mb-2">
                <label for="sku" class="form-label">
                    Sku
                    <span class="required"></span>
                </label>
                <input type="text" id="sku" name="sku" class="form-control" value="{{ $data['sku'] }}"/>
            </div>
            <div class="mb-2">
                <label for="name" class="form-label">
                    Nombre
                    <span class="required"></span>
                </label>
                <input type="text" id="name" name="name" class="form-control form-reset" value="{{ $data['name'] }}"/>
            </div>
            <div class="mb-2">
                <label for="subname" class="form-label">
                    Subnombre
                </label>
                <input type="text" id="subname" name="subname" class="form-control form-reset" value="{{ $data['subname'] }}"/>
            </div>
            <div class="mb-2">
                <label for="review" class="form-label">
                    Resumen
                </label>
                <input type="text" id="review" name="review" class="form-control form-reset" value="{{ $data['review'] }}"/>
            </div>
            <div class="mb-2">
                <label for="description" class="form-label">
                    Descripción
                </label>
                <input type="text" id="description" name="description" class="form-control form-reset" value="{{ $data['description'] }}"/>
            </div>
            <div class="mb-2">
                <label for="gtin" class="form-label">
                    Gtin
                </label>
                <input type="text" id="gtin" name="gtin" class="form-control" value="{{ $data['gtin'] }}"/>
            </div>
            <div class="mb-2">
                <label for="weight" class="form-label">
                    Peso
                    <span data-wenk="Kilogramos">
                        <i class="fal fa-circle-info"></i>
                    </span>
                </label>
                <input type="text" id="weight" name="weight" class="form-control" value="{{ $data['weight'] }}"/>
            </div>
            <div class="mb-2">
                <label for="note" class="form-label">
                    Nota
                </label>
                <input type="text" id="note" name="note" class="form-control" value="{{ $data['note'] }}"/>
            </div>
            <div class="mb-3">
                <label for="status" class="form-label">
                    Estatus
                    <span class="required"></span>
                </label>
                <select id="status" name="status" class="form-select">
                    <option value="Borrador" @selected($data['status'] == 'Borrador')>
                        Borrador
                    </option>
                    @if($data['status'] == 'Activo')
                    <option value="Activo" @selected($data['status'] == 'Activo')>
                        Activo
                    </option>
                    @endif
                    <option value="Cancelado" @selected($data['status'] == 'Cancelado')>
                        Cancelado
                    </option>
                </select>
            </div>
            <button type="submit" class="btn btn-outline-mca">
                Actualizar
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
