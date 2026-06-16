<div class="overlap-wrap-xs">
    <div class="overlap-header">
        <div class="overlap-close"></div>
        <div class="img-container">
            <img src="{{ asset('images/mercadopago.svg') }}" width="150px">
        </div>
    </div>
    <div class="overlap-payment">
        <div id="payment_container"></div>
    </div>
</div>
<script>
    const MERCADOPAGO = {
        CSRF: @json(csrf_token()),
        KEY: @json(config('services.mercadopago.key', env('MERCADOPAGO_KEY'))),
        PAY_ORDER: @json(route('carrito/mercadopago/pagar')),
        REDIRECT_URL: @json(route('carrito/exito')),
        TOTAL: @json(floatval($checkout['total'])),
        PREFERENCE_ID: @json($preference->id),
    };
</script>
<script src="{{ asset('js/mercadopago.js?v=1.1.5') }}"></script>