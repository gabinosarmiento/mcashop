@if($data['last_page'] > 1)
<nav class="wrapper-pagination" aria-label="pagination navigation">
    <ul class="pagination justify-content-end mb-2">
        <!-- Previous -->
        @if($data['current_page'] > 1)
        <li class="page-item">
            <button type="button" id="action-paginate-previous" class="page-link" data-route="registros?{{ request()->withQuery(['page' => $data['current_page'] - 1]) }}" data-inner="#records-output" rel="prev">
                @lang('pagination.previous')
            </button>
        </li>
        @else
        <li class="page-item disabled" aria-disabled="true">
            <span class="page-link">
                @lang('pagination.previous')
            </span>
        </li>
        @endif
        <!-- Pages -->
        @foreach($data['links'] as $link)
        @continue($loop->first || $loop->last)
        @if($link['url'])
        <li @class(['page-item', 'active' => $link['active']])>
            @if($link['active'])
            <span class="page-link">
                {{ $link['label'] }}
            </span>
            @else
            <button type="button" id="action-paginate-page-{{ $link['label'] }}" class="page-link" data-route="registros?{{ request()->withQuery(['page' => $link['label']]) }}" data-inner="#records-output">
                {{ $link['label'] }}
            </button>
            @endif
        </li>
        @else
        <li class="page-item disabled" aria-disabled="true">
            <span class="page-link">
                {{ $link['label'] }}
            </span>
        </li>
        @endif
        @endforeach
        <!-- Next -->
        @if($data['current_page'] < $data['last_page'])
        <li class="page-item">
            <button type="button" id="action-paginate-next" class="page-link" data-route="registros?{{ request()->withQuery(['page' => $data['current_page'] + 1]) }}" data-inner="#records-output" rel="next">
                @lang('pagination.next')
            </button>
        </li>
        @else
        <li class="page-item disabled" aria-disabled="true">
            <span class="page-link">
                @lang('pagination.next')
            </span>
        </li>
        @endif
    </ul>
    <small class="text-muted">
        {!! __('Showing') !!}
        <span class="fw-semibold">
            {{ $data['from'] }}
        </span>
        {!! __('to') !!}
        <span class="fw-semibold">
            {{ $data['to'] }}
        </span>
        {!! __('of') !!}
        <span class="fw-semibold">
            {{ $data['total'] }}
        </span>
        {!! __('results') !!}
    </small>
</nav>
@endif
