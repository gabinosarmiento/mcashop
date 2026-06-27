<div class="box">
    <table class="table table-hover">
        <thead>
            <tr>
                <th>
                    Nombre
                </th>
            </tr>
        </thead>
        <tbody>
            @forelse($data['data'] as $record)
            <tr id="action-see-administrative-{{ $record['id'] }}" class="{{ $record['status'] }}" data-route="ver?{{ request()->withQuery(['id' => $record['id']]) }}" data-overlap-show="#overapp">
                <td>
                    {{ $record['firstname'] }} {{ $record['lastname'] }}
                </td>
            </tr>
            @empty
            <tr>
                <td class="text-muted">
                    ...
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@include('partials.pagination')
