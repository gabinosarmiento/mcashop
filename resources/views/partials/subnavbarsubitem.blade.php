<li class="dropdown-node">
    @if(empty($item['submenu']))
    <a class="dropdown-item" href="{{ route('categorias/categoria', [$item['id'], str($item['name'])->slug()]) }}">
        {{ $item['name'] }}
    </a>
    @else
    <button type="button" class="dropdown-item dropdown-item-toggle">
        {{ $item['name'] }}
    </button>
    <ul class="submenu dropdown-menu">
        @foreach($item['submenu'] as $subitem)
        @include('partials.subnavbarsubitem', ['item' => $subitem])
        @endforeach
    </ul>
    @endif
</li>
