<div class="overlap-wrap-sm">
    <div class="overlap-header">
        <div class="overlap-close"></div>
        Producto
    </div>
    <div class="overlap-body">
        @include('administrative.assistant.product.toolbar')
        <div class="tab-content">
            <div class="tab-pane fade show active" id="product-tab" role="tabpanel">
                @include('administrative.assistant.product.product')
            </div>
            <div class="tab-pane fade" id="features-tab" role="tabpanel">
                <div id="features-output"></div>
            </div>
            <div class="tab-pane fade" id="search-tab" role="tabpanel"></div>
            <div class="tab-pane fade" id="health-tab" role="tabpanel"></div>
            <div class="tab-pane fade" id="relations-tab" role="tabpanel">
                <div id="relations-output"></div>
            </div>
            <div class="tab-pane fade" id="images-tab" role="tabpanel">
                <form id="change-image-form" data-method="post" data-route="imagen/guardar" data-reset="true">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $data['id'] }}"/>
                    <input type="file" id="image" name="image" class="d-none"/>
                    <div class="mb-2">
                        <label class="btn btn-outline-secondary" for="image">
                            <i class="fal fa-image"></i>
                            Imagen
                        </label>
                    </div>
                </form>
                <div id="images">
                    @include('administrative.assistant.product.images')
                </div>
            </div>
        </div>
    </div>
</div>
