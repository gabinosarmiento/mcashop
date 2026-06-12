<div class="box box-blue">
    <div class="box-header">
        <div class="box-title">
            <i class="fas fa-user"></i>
        </div>
    </div>
    <div class="box-body">
        <table class="table table-borderless">
            <tr>
                <th width="90">
                    Nombre
                </th>
                <td>
                    {{ $data['firstname'] }}
                </td>
            </tr>
            <tr>
                <th>
                    Apellido
                </th>
                <td>
                    {{ $data['lastname'] }}
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
        </table>
    </div>
    <div class="box-footer text-end">
        <button type="button" id="action-account-edit" data-route="editar" data-overlap-show="#overlap-one" class="btn btn-subtle-flat">
            <i class="fa-light fa-pen"></i>
            Editar
        </button>
    </div>
</div>