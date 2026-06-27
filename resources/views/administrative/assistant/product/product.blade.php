<div class="row">
    <div class="col-auto">
        <div id="image-html">
            @include('administrative.image')
        </div>
    </div>
    <div class="col">
        <table class="table table-borderless">
            <tr>
                <th width="100">
                    Id
                </th>
                <td>
                    <span id="id">
                        {{ $data['id'] }}
                    </span>
                    <button class="btn btn-link btn-copy" data-target="#id">
                        <i class="fal fa-clone"></i>
                    </button>
                </td>
            </tr>
            <tr>
                <th>
                    Sku
                </th>
                <td>
                    <span id="sku">
                        {{ $data['sku'] }}
                    </span>
                    <button class="btn btn-link btn-copy" data-target="#sku">
                        <i class="fal fa-clone"></i>
                    </button>
                </td>
            </tr>
            <tr>
                <th>
                    Marca
                </th>
                <td>
                    <span id="brand">
                        {{ $data['brand']['name'] }}
                    </span>
                    <button class="btn btn-link btn-copy" data-target="#brand">
                        <i class="fal fa-clone"></i>
                    </button>
                </td>
            </tr>
            <tr>
                <th>
                    Categoría
                </th>
                <td>
                    @isset($data['category']['name'])
                    <span id="category">
                        {{ $data['category']['name'] }}
                    </span>
                    <button class="btn btn-link btn-copy" data-target="#category">
                        <i class="fal fa-clone"></i>
                    </button>
                    @else
                    ...
                    @endisset
                </td>
            </tr>
            <tr>
                <th class="align-top">
                    Nombre
                </th>
                <td>
                    <span id="name">
                        {{ $data['name'] }}
                    </span>
                    <button class="btn btn-link btn-copy" data-target="#name">
                        <i class="fal fa-clone"></i>
                    </button>
                </td>
            </tr>
            <tr>
                <th class="align-top">
                    Subnombre
                </th>
                <td>
                    {{ $data['subname'] ?? '...' }}
                </td>
            </tr>
            <tr>
                <th class="align-top">
                    Resumen
                </th>
                <td>
                    {{ $data['review'] ?? '...' }}
                </td>
            </tr>
            <tr>
                <th class="align-top">
                    Descripción
                </th>
                <td>
                    {!! $data['description'] ?? '...' !!}
                </td>
            </tr>
            <tr>
                <th>
                    Gtin
                </th>
                <td>
                    {{ $data['gtin'] ?? '...' }}
                </td>
            </tr>
            <tr>
                <th>
                    Peso
                </th>
                <td>
                    {{ $data['weight'] ?? '...' }}kg
                </td>
            </tr>
            <tr>
                <th>
                    Nota
                </th>
                <td>
                    {{ $data['note'] ?? '...' }}
                </td>
            </tr>
            <tr>
                <th>
                    Creado
                </th>
                <td>
                    {{ $data['created_at'] }}
                </td>
            </tr>
            <tr>
                <th>
                    Actualizado
                </th>
                <td>
                    {{ $data['updated_at'] }}
                </td>
            </tr>
            <tr>
                <th>
                    Icecat
                </th>
                <td>
                    {{ $data['icecat'] ? 'Disponible' : 'No disponible' }}
                </td>
            </tr>
            <tr>
                <th>
                    Estatus
                </th>
                <th class="{{ $data['status'] }}">
                    {{ $data['status'] }}
                </th>
            </tr>
        </table>
    </div>
</div>
