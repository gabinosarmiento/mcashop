@empty($data['modules'])
<div class="console">
    <i class="fal fa-sparkles text-secondary"></i>
</div>
@else
<div class="box">
    <table class="table table-hover">
        <thead class="header">
            <tr>
                <th width="42">
                    <i class="fal fa-circle-xmark"></i>
                </th>
                <th>
                    Módulo
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach($data['modules'] as $module)
            <tr>
                <td>
                    <button type="button" class="btn btn-link" id="delete-administrative-module-delete-{{ $module['id'] }}" data-route="modulo/eliminar?{{ request()->withQuery(['id' => $module['id'], 'administrative_id' => $module['administrative_id']]) }}" data-wenk="Eliminar" data-wenk-position="right">
                        <i class="fal fa-circle-xmark"></i>
                    </button>
                </td>
                <td>
                    {{ MODULE[$module['module']] }}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endif