@empty($data)
<button type="button" id="action-customer-address-add" class="btn btn-subtle-flat" data-route="agregar" data-overlap-show="#overlap-one">
    <i class="fa-light fa-plus"></i>
    Agregar dirección
</button>
@else
<div class="box box-blue">
    <div class="box-header">
        <div class="box-title">
            <i class="fas fa-location-pin"></i>
        </div>
    </div>
    <div class="box-body">
        <table class="table table-borderless">
            <tr>
                <th width="100">
                    Nombre
                </th>
                <td>
                    {{ $data['name'] }}
                </td>
            </tr>
            <tr>
                <th>
                    Teléfono
                </th>
                <td>
                    {{ $data['phone'] }}
                </td>
            </tr>
            <tr>
                <th>
                    Correo
                </th>
                <td>
                    {{ $data['email'] }}
                </td>
            </tr>
            <tr>
                <th>
                    Calle
                </th>
                <td>
                    {{ $data['street'] }}
                </td>
            </tr>
            <tr>
                <th>
                    Entrecalles
                </th>
                <td>
                    {{ $data['streets'] }}
                </td>
            </tr>
            <tr>
                <th>
                    Referencia
                </th>
                <td>
                    {{ $data['reference'] ?? '...' }}
                </td>
            </tr>
            <tr>
                <th>
                    Colonia
                </th>
                <td>
                    {{ $data['colony'] }}
                </td>
            </tr>
            <tr>
                <th>
                    Ciudad
                </th>
                <td>
                    {{ $data['city'] }}
                </td>
            </tr>
            <tr>
                <th>
                    Estado
                </th>
                <td>
                    {{ $data['state'] }}
                </td>
            </tr>
            <tr>
                <th>
                    País
                </th>
                <td>
                    {{ $data['country'] }}
                </td>
            </tr>
            <tr>
                <th>
                    CP
                </th>
                <td>
                    {{ $data['zc'] }}
                </td>
            </tr>
        </table>
    </div>
    <div class="box-footer text-end">
        <button type="button" id="action-address-edit" data-route="editar/{{ $data['id'] }}" data-overlap-show="#overlap-one" class="btn btn-subtle-flat">
            <i class="fa-light fa-pen"></i>
            Editar
        </button>
    </div>
</div>
@endempty
