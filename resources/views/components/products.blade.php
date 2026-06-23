<div class="container">
    {{ Breadcrumbs::render($source, $data) }}
    <div class="layout-mca">
        <aside class="sidebar-mca d-none d-lg-block">
            <form id="submit-filter" data-action="{{ route($source, [$data['id'], str($data['name'])->slug()]) }}">
                @include('partials.filters', ['prefix' => 'desktop'])
            </form>
        </aside>
        <section class="content-mca">
            <div class="grid grid-section mb-4">
                @foreach($data['data'] as $product)
                @include('store.card', compact('product'))
                @endforeach
            </div>
            @include('store.pagination')
        </section>
    </div>
</div>