@if($data['last_page'] > 1)
<nav class="d-flex justify-items-center justify-content-between">
    <div class="d-flex justify-content-between flex-fill d-sm-none">
        <ul class="pagination">
            @if($data['prev_page_url'])
            <li class="page-item">
                <a class="page-link" href="{{ $data['prev_page_url'] }}" rel="prev">
                    @lang('pagination.previous')
                </a>
            </li>
            @else
            <li class="page-item disabled" aria-disabled="true">
                <span class="page-link">
                    @lang('pagination.previous')
                </span>
            </li>
            @endif
            @if($data['next_page_url'])
            <li class="page-item">
                <a class="page-link" href="{{ $data['next_page_url'] }}" rel="next">
                    @lang('pagination.next')
                </a>
            </li>
            @else
            <li class="page-item disabled" aria-disabled="true">
                <span class="page-link">
                    @lang('pagination.next')
                </span>
            </li>
            @endif
        </ul>
    </div>
    <div class="d-none flex-sm-fill d-sm-flex align-items-sm-center justify-content-sm-between">
        <div>
            <p class="small text-muted">
                {!! __('Showing') !!}
                <span class="fw-semibold">{{ $data['from'] }}</span>
                {!! __('to') !!}
                <span class="fw-semibold">{{ $data['to'] }}</span>
                {!! __('of') !!}
                <span class="fw-semibold">{{ $data['total'] }}</span>
                {!! __('results') !!}
            </p>
        </div>
        <div>
            <ul class="pagination">
                @if($data['prev_page_url'])
                <li class="page-item">
                    <a class="page-link" href="{{ $data['prev_page_url'] }}" rel="prev" aria-label="@lang('pagination.previous')">
                        &lsaquo;
                    </a>
                </li>
                @else
                <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">
                    <span class="page-link" aria-hidden="true">
                        &lsaquo;
                    </span>
                </li>
                @endif
                @foreach($data['links'] as $link)
                    @if($loop->first || $loop->last)
                        @continue
                    @endif

                    <li class="page-item{{ $link['active'] ? ' active' : '' }}">
                        @if($link['active'])
                        <span class="page-link">
                            {{ $link['label'] }}
                        </span>
                        @else
                        <a class="page-link" href="{{ $link['url'] }}">
                            {{ $link['label'] }}
                        </a>
                        @endif
                    </li>
                @endforeach
                @if($data['next_page_url'])
                <li class="page-item">
                    <a class="page-link" href="{{ $data['next_page_url'] }}" rel="next" aria-label="@lang('pagination.next')">
                        &rsaquo;
                    </a>
                </li>
                @else
                <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.next')">
                    <span class="page-link" aria-hidden="true">
                        &rsaquo;
                    </span>
                </li>
                @endif
            </ul>
        </div>
    </div>
</nav>
@endif