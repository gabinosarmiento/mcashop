<select class="form-select mb-3">
    <option selected disabled>
        Orden
    </option>
    <optgroup label="Nombre">
        <option value="asc" {{ request()->input('order') == 'asc' ? 'selected' : '' }}>
            A - Z
        </option>
        <option value="desc" {{ request()->input('order') == 'desc' ? 'selected' : '' }}>
            Z - A
        </option>
    </optgroup>
    <optgroup label="Precio">
        <option value="low" {{ request()->input('order') == 'low' ? 'selected' : '' }}>
            Menor - Mayor
        </option>
        <option value="high" {{ request()->input('order') == 'high' ? 'selected' : '' }}>
            Mayor - Menor
        </option>
    </optgroup>
</select>
