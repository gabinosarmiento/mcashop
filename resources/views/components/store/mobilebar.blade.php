<div class="offcanvas offcanvas-start" tabindex="-1" id="mobile-sidebar">
    <div class="offcanvas-header">
        <a href="{{ route('inicio') }}">
            <img src="{{ asset('images/logo.svg') }}" class="logo" alt="mcashop" width="135"/>
        </a>
        <button type="button" class="btn-close position-absolute end-0 me-3" data-bs-dismiss="offcanvas"></button>
    </div>
    <div class="offcanvas-body">
        <form id="submit-mobile-filter" data-action="{{ route($source, [$data['id'], str($data['name'])->slug()]) }}">
            @include('partials.filters', ['prefix' => 'mobile'])
        </form>
    </div>
</div>
