<div class="mb-2">
    <label for="colony" class="form-label">
        Colonia
        <span class="required"></span>
    </label>
    <select name="colony" class="form-select">
        <option value="">
            Seleccionar una opción
        </option>
        @foreach($data['colonies'] as $colony)
        <option value="{{ $colony }}">
            {{ $colony }}
        </option>
        @endforeach
    </select>
</div>
<div class="mb-2">
    <label for="city" class="form-label">
        Ciudad
        <span class="required"></span>
    </label>
    <input type="text" name="city" class="form-control" value="{{ $data['city'] }}" readonly/>
</div>
<div class="mb-2">
    <label for="state" class="form-label">
        Estado
        <span class="required"></span>
    </label>
    <input type="text" name="state" class="form-control" value="{{ $data['state'] }}" readonly/>
</div>
<div class="mb-2">
    <label for="country" class="form-label">
        País
        <span class="required"></span>
    </label>
    <input type="text" name="country" class="form-control" value="México" readonly/>
</div>
