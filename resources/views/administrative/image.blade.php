<div class="picture picture-circle picture-md picture-border-dashed">
    <div class="showme-wrap">
        <img class="img-fluid" src="{{ asset($data['image']) }}" alt="..."/>
        <div class="showme showme-over">
            <form id="change-picture-form" data-route="imagen" data-method="post" data-inner="#image-html">
                @csrf
                <input type="hidden" name="id" value="{{ $data['id'] }}"/>
                <input type="file" id="image" name="image" class="showme-input"/>
                <label for="image">
                    <i class="fal fa-arrow-up-long"></i>
                </label>
            </form>
        </div>
    </div>
</div>