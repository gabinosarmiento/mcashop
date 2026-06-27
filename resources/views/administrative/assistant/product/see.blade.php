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
                    {{ csrf_field() }}
                    <input type="hidden" name="product_id" value="{{ $data['id'] }}"/>
                    <div class="form-group">
                        <div class="input-group">
                            <div class="custom-file">
                                <input type="file" id="image" name="image" class="d-none"/>
                                <label class="btn btn-outline-mca" for="image">
                                    <i class="fal fa-image"></i>
                                    Imagen
                                </label>
                            </div>
                        </div>
                    </div>
                </form>
                <div id="images-inner"></div>
            </div>
        </div>
    </div>
</div>
