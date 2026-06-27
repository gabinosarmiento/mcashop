@empty($data['images'])
<div class="board">
    ...
</div>
@else
<div class="grid grid-cols-4 grid-cols-sm-6 grid-xl-cols-8 grid-xxl-cols-10">
    @foreach($data['images'] as $image)
    <div class="card">
        <div class="showme-wrap">
            <a href="{{ asset($image['name']) }}" target="_blank">
                <img class="img-fluid rounded" src="{{ asset($image['name']) }}" alt="..."/>
            </a>
            <span class="showme showme-button">
                <button type="button" class="btn btn-link" id="delete-media-{{ $image['id'] }}" data-route="imagen/eliminar?{{ request()->withQuery(['id' =>$image['id'], 'product_id' =>$image['product_id']]) }}">
                    <i class="fal fa-circle-xmark"></i>
                </button>
            </span>
        </div>
    </div>
    @endforeach
</div>
@endempty


