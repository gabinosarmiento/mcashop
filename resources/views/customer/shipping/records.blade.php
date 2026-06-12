@empty($data)
<div class="console">
    Sin pedidos
</div>
@else
<div class="box box-blue">
    <div class="box-header">
        <div class="box-title">
            <i class="fas fa-file-lines"></i>
        </div>
    </div>
    <div class="box-body">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>
                        Folio
                    </th>
                    <th>
                        Fecha
                    </th>
                    <th class="text-end">
                        Total
                    </th>
                    <th class="text-center" width="85">
                       Estado
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach($data as $record)
                <tr id="action-shipping-see" class="{{ $record['status'] }}" data-route="ver/{{ $record['id'] }}" data-overlap-show="#overlap-one">
                    <td>
                        {{ $record['folio'] }}
                    </td>
                    <td>
                        {{ $record['created_at'] }}
                    </td>
                    <th class="text-end">
                     <small>
                        $
                     </small>
                        {{ number_format($record['total'], 2) }}
                    </td>
                    <th class="text-center">
                       <span>
                           @switch($record['status'])
                           @case('Proceso')
                           <i class="fa-light fa-clock"></i>
                           @break
                           @case('Cancelado')
                           <i class="fa-light fa-ban"></i>
                           @break
                           @case('Completado')
                           <i class="fa-light fa-check"></i>
                           @break
                           @default
                           <i class="fa-light fa-circle"></i>
                           @endswitch
                        </span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endempty
