<div class="box">
    <table class="table table-hover">
        <thead>
            <tr>
                <th>
                    Sku
                </th>
                <th>
                    Nombre
                </th>
            </tr>
        </thead>
        <tbody>
            @forelse($data['data'] as $record)
            <tr id="action-see-product-{{ $record['id'] }}" class="{{ $record['status'] }}" data-route="ver?{{ request()->withQuery(['id' => $record['id']]) }}" data-overlap-show="#overapp">
               <td>
                  <strong>
                     {{ $record['sku'] }}
                  </strong>
               </td>
               <td>
                  {{ $record['name'] }}
               </td>
            </tr>
            @empty
            <tr>
                <td colspan="2" class="text-muted">
                    ...
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@include('administrative.pagination')
