<div class="busqueda">
    <form id="ajax-search-form" data-method="get" data-route="registros?{{ request()->withQuery() }}" data-reset="false">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Buscar"/>
            <button type="submit" class="btn btn-secondary">
                <i class="fal fa-search"></i>
            </button>
        </div>
    </form>
</div>