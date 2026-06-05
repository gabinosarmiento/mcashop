<li class="{{ $submenu ? 'sidebar-subitem' : 'sidebar-item' }}">
   @if(empty($item['submenu']))
   <a class="sidebar-sublink pl-2" href="{{ route('categorias/categoria', [$item['id'], str($item['name'])->slug()]) }}">
      {{ $item['name'] }}
   </a>
   @else
   <span class="font-weight-bold {{ $submenu ? 'sidebar-sublink' : 'sidebar-link' }} collapsed @if($path === 'path-root') sidebar-caret @endif" data-toggle="collapse" data-target="#submenu-{{ "{$path}-{$item['id']}" }}" aria-expanded="false" aria-controls="submenu-{{ "{$path}-{$item['id']}" }}">
      {{ $item['name'] }}
   </span>
   <ul class="list-unstyled @if($path === 'path-root') sidebar-submenu @endif collapse" id="submenu-{{ "{$path}-{$item['id']}" }}" data-parent="#{{ $parent }}">
      @foreach($item['submenu'] as $subitem)
      @include('partials.mobilesubitem', ['item' => $subitem, 'submenu' => true, 'path' => "{$path}-{$item['id']}", 'parent' => "submenu-{$path}-{$item['id']}"])
      @endforeach
   </ul>
   @endif
</li>
