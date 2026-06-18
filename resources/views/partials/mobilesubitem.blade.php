<li class="{{ $submenu ? 'sidebar-subitem' : 'sidebar-item' }}">
    @if(empty($item['submenu']))
    <a class="{{ $submenu ? 'sidebar-sublink' : 'sidebar-link' }}" href="{{ route('categoria', [$item['id'], str($item['name'])->slug()]) }}">
        {{ $item['name'] }}
    </a>
    @else
    <span class="{{ $submenu ? 'sidebar-sublink' : 'sidebar-link' }} sidebar-caret collapsed" data-bs-toggle="collapse" data-bs-target="#submenu-{{ $item['id'] }}" aria-expanded="false">
        {{ $item['name'] }}
    </span>
    <ul class="sidebar-submenu list-unstyled collapse" id="submenu-{{ $item['id'] }}">
        @foreach($item['submenu'] as $subitem)
        @include('partials.mobilesubitem', ['item' => $subitem,'submenu' => true])
        @endforeach
    </ul>
    @endif
</li>
