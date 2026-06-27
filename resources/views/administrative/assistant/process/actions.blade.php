@php
$dropdown = [
    'tools' => [
        [
            'code'  => 'WTCH',
            'label' => 'watchdog',
            'name'  => 'Supervisor',
        ],
        [
            'code'  => 'DBUP',
            'label' => 'backup:db',
            'name'  => 'Respaldo DB',
        ],
        [
            'code'  => 'HLTH',
            'label' => 'product:health',
            'name'  => 'Producto salud',
        ],
        [
            'code'  => 'ICE',
            'label' => 'products:icecat',
            'name'  => 'Productos Icecat',
        ],
        [
            'code'  => 'SCH',
            'label' => 'product:search',
            'name'  => 'Productos búsqueda',
        ],
        [
            'code'  => 'DUPS',
            'label' => 'products:dups',
            'name'  => 'Productos duplicados',
        ],
    ],
    'products' => [
        [
            'code'  => 'CT',
            'label' => 'products:ct',
            'name'  => 'Productos CT',
        ],
        [
            'code'  => 'CVA',
            'label' => 'products:cva',
            'name'  => 'Productos CVA',
        ],
        [
            'code'  => 'EXEL',
            'label' => 'products:exel',
            'name'  => 'Productos EXEL',
        ],
        [
            'code'  => 'INTCOMEX',
            'label' => 'products:intcomex',
            'name'  => 'Productos INTCOMEX',
        ],
        [
            'code'  => 'LOMA',
            'label' => 'products:loma',
            'name'  => 'Productos LOMA',
        ],
        [
            'code'  => 'SYSCOM',
            'label' => 'products:syscom',
            'name'  => 'Productos SYSCOM',
        ],
        [
            'code'  => 'TEAM',
            'label' => 'products:team',
            'name'  => 'Productos TEAM',
        ],
        [
            'code'  => 'TVC',
            'label' => 'products:tvc',
            'name'  => 'Productos TVC',
        ],
    ],
    'inventory' => [
        [
            'code'  => 'CT',
            'label' => 'inventory:ct',
            'name'  => 'Inventario CT',
        ],
        [
            'code'  => 'CVA',
            'label' => 'inventory:cva',
            'name'  => 'Inventario CVA',
        ],
        [
            'code'  => 'EXEL',
            'label' => 'inventory:exel',
            'name'  => 'Inventario EXEL',
        ],
        [
            'code'  => 'INTCOMEX',
            'label' => 'inventory:intcomex',
            'name'  => 'Inventario INTCOMEX',
        ],
        [
            'code'  => 'LOMA',
            'label' => 'inventory:loma',
            'name'  => 'Inventario LOMA',
        ],
        [
            'code'  => 'SYSCOM',
            'label' => 'inventory:syscom',
            'name'  => 'Inventario SYSCOM',
        ],
        [
            'code'  => 'TEAM',
            'label' => 'inventory:team',
            'name'  => 'Inventario TEAM',
        ],
        [
            'code'  => 'TVC',
            'label' => 'inventory:tvc',
            'name'  => 'Inventario TVC',
        ],
    ]
];
@endphp
<div class="d-flex justify-content-end gap-2">
    <div class="dropdown">
        <button type="button" id="dropdown-tools" class="btn btn-outline-secondary" data-bs-toggle="dropdown" data-wenk="Herramientas">
            <i class="fal fa-toolbox"></i>
        </button>
        <div class="dropdown-menu" aria-labelledby="dropdown-tools">
            @foreach ($dropdown['tools'] as $item)
            <button type="button" id="action-tools-{{ $item['code'] }}" class="dropdown-item" data-route="ejecutar?{{ request()->withQuery(['label' => $item['label']]) }}">
                {{ $item['name'] }}
            </button>
            @endforeach
        </div>
    </div>
    <div class="dropdown">
        <button type="button" id="dropdown-products" class="btn btn-outline-secondary" data-bs-toggle="dropdown" data-wenk="Productos">
            <i class="fal fa-truck"></i>
        </button>
        <div class="dropdown-menu" aria-labelledby="dropdown-products">
            @foreach ($dropdown['products'] as $item)
            <button type="button" id="action-products-{{ $item['code'] }}" class="dropdown-item" data-route="ejecutar?{{ request()->withQuery(['label' => $item['label']]) }}">
                {{ $item['name'] }}
            </button>
            @endforeach
        </div>
    </div>
    <div class="dropdown">
        <button type="button" id="dropdown-inventory" class="btn btn-outline-secondary" data-bs-toggle="dropdown" data-wenk="Inventario">
            <i class="fal fa-box"></i>
        </button>
        <div class="dropdown-menu" aria-labelledby="dropdown-inventory">
            @foreach ($dropdown['inventory'] as $item)
            <button type="button" id="action-inventory-{{ $item['code'] }}" class="dropdown-item" data-route="ejecutar?{{ request()->withQuery(['label' => $item['label']]) }}">
                {{ $item['name'] }}
            </button>
            @endforeach
        </div>
    </div>
</div>
