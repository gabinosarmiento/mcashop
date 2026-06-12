<select name="order" class="form-select mb-3">
    <option disabled @selected(!request()->filled('order'))>
        Ordenar
    </option>
    <option value="asc" @selected(request('order') == 'asc')>
        Nombre a ~ z
    </option>
    <option value="desc" @selected(request('order') == 'desc')>
        Nombre z ~ a
    </option>
    <option value="low" @selected(request('order') == 'low')>
        Precio mínimo
    </option>
    <option value="high" @selected(request('order') == 'high')>
        Precio máximo
    </option>
</select>