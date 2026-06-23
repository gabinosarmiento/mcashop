<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\CarrierRateModel;
use App\Models\CarrierZoneModel;
use App\Models\ColonyModel;
use App\Models\CustomerModel;
use App\Models\ErrorModel;
use App\Models\ProductInventoryModel;
use App\Models\QuoteModel;
use App\Models\QuoteProductModel;
use App\Models\ShippingModel;
use App\Models\ShippingProductModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use MercadoPago\Client\Payment\PaymentClient;
use MercadoPago\Client\Preference\PreferenceClient;
use MercadoPago\Exceptions\MPApiException;
use MercadoPago\MercadoPagoConfig;
use Throwable;
use Exception;

class Cart extends Controller
{
    public function invoice(Request $request)
    {
        Session::forget('_invoice');

        if ($request->boolean('change-invoice')) {
            Session::put('_invoice', true);
        }

        return response(['checked' => Session::has('_invoice')]);
    }

    public function index()
    {
        $data = Session::get('_cart');

        $data['menu'] = $this->menu_categories();

        return view('cart.index', compact('data'));
    }

    /**
     * Adds a product inventory record to the shopping cart.
     *
     * The method prevents duplicate items, loads all related product
     * information (supplier, brand, category and inventory data),
     * builds the cart item payload and calculates the initial financial
     * values before shipping is applied.
     *
     * Stored item fields:
     * product_id : Internal product identifier.
     * sku        : Product SKU/code.
     * name       : Product display name.
     * quantity   : Selected quantity.
     * charge     : Product total with VAT, excluding shipping.
     * discount   : Discount amount excluding VAT.
     * shipment   : Shipping amount excluding VAT.
     * shipping   : Shipping amount including VAT.
     * weight     : Product weight.
     * image      : Product image.
     * brand      : Brand name.
     * category   : Category name.
     * supplier   : Supplier code.
     * id         : Inventory record identifier.
     * zc         : Origin postal/zone code.
     * cost       : Supplier cost excluding VAT.
     * price      : Public unit price including VAT.
     * stock      : Available stock.
     * markup     : Applied markup percentage.
     * location   : Supplier warehouse/location.
     *
     * Calculated fields:
     * freight    : Total freight weight for the line (weight × quantity).
     * unit       : Unit price excluding VAT.
     * value      : Taxable unit value.
     * base       : Taxable line base.
     * amount     : Taxable amount after discount.
     * vat        : VAT amount.
     * subtotal   : Product subtotal excluding VAT.
     * total      : Final line total including VAT.
     *
     * Cart totals are updated immediately. Shipping values remain zero
     * until the checkout process calculates destination-based freight.
     *
     * @param int $id Inventory identifier.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function add($id)
    {
        $cart = Session::get('_cart');

        foreach ($cart['products'] as $item) {
            if ($item['id'] == $id) {
                return response(['message' => 'Este producto ya está en tu carrito.'], 400);
            }
        }

        # Queries
        $inventory = ProductInventoryModel::find($id);

        $relation = $inventory->relation;

        $supplier = $relation->supplier;

        $product = $relation->product;

        $category = $product->category;

        $brand = $product->brand;

        $new = [
            // Internal product identifier
            'product_id' => $product->id,
            // Product SKU/code
            'sku'        => $product->sku,
            // Product display name
            'name'       => $product->name,
            // Selected quantity
            'quantity'   => 1,
            // Product total with VAT, excluding shipping
            'charge'     => 0.0,
            // Discount amount excluding VAT
            'discount'   => 0.0,
            // Shipping amount excluding VAT
            'shipment'   => 0.0,
            // Shipping amount including VAT
            'shipping'   => 0.0,
            // Product weight used to calculate freight
            'weight'     => $product->weight,
            // Product image
            'image'      => $product->image,
            // Brand name
            'brand'      => $brand->name,
            // Category name
            'category'   => $category->name,
            // Supplier code
            'supplier'   => $supplier->code,
            // Inventory record identifier
            'id'         => $inventory->id,
            // Origin postal/zone code
            'zc'         => $inventory->zc,
            // Supplier cost excluding VAT
            'cost'       => $inventory->cost,
            // Public unit price including VAT
            'price'      => $inventory->price,
            // Available stock
            'stock'      => $inventory->stock,
            // Applied markup percentage
            'markup'     => $inventory->markup,
            // Supplier warehouse/location
            'location'   => $inventory->location,
        ];

        # Calculations

        // Total freight weight for the line (weight × quantity)
        $new['freight'] = round($new['weight'] * $new['quantity'], 2);
        // Unit price excluding VAT
        $new['unit'] = round(iva_breakdown($new['price']), 2);
        // Taxable unit value
        $new['value'] = $new['unit'];
        // Taxable line base
        $new['base'] = round($new['value'] * $new['quantity'], 2);
        // Taxable amount after discount
        $new['amount'] = round($new['base'] - $new['discount'], 2);
        // Product total with VAT, excluding shipping
        $new['charge'] = round($new['price'] * $new['quantity'], 2);
        // VAT amount
        $new['vat'] = round(iva_calculate($new['amount']), 2);
        // Final line total including VAT
        $new['total'] = round($new['amount'] + $new['vat'], 2);
        // Product subtotal excluding VAT
        $new['subtotal'] = round($new['unit'] * $new['quantity'], 2);

        # Cart totals

        // Accumulate total freight weight
        $cart['freight'] += $new['freight'];
        // Accumulate product subtotal excluding VAT
        $cart['subtotal'] += $new['subtotal'];
        // Accumulate taxable amount
        $cart['amount'] += $new['amount'];
        // Accumulate VAT amount
        $cart['vat'] += $new['vat'];
        // Accumulate cart total including VAT
        $cart['total'] += $new['total'];

        // Append item to cart
        $cart['products'][] = $new;

        Session::put('_cart', $cart);

        return response(['message' => 'El producto se ha agregado con éxito al carrito.', 'render' => ['_cart' => count($cart['products'])]]);
    }

    public function checkout()
    {
        // Will hold recalculated product rows (with shipping/tax breakdown applied)
        $items = [];

        // Load current cart payload from session
        $data = Session::get('_cart');

        $data['menu'] = $this->menu_categories();

        // Load logged-in customer with shipping address + billing data
        $customer = CustomerModel::with('address', 'billing')->find(auth('customer')->id());

        if ($customer) {
            // Inject billing info into checkout payload
            if ($customer->billing) {
                $data['billing'] = $customer->billing->toArray();
            }

            // Inject shipping address and calculate totals only if address exists
            if ($customer->address) {
                $data['address'] = $customer->address->toArray();

                // Initialize numeric totals to 0.0 (freight/shipment/subtotal/amount/vat/total)
                $data = array_merge($data, array_fill_keys(['freight', 'shipping', 'shipment', 'subtotal', 'amount', 'vat', 'total'], 0.0));

                // Resolve destination zone based on customer's ZIP/colony code
                $destiny_zone = ColonyModel::where('zc', $data['address']['zc'])->value('zone');

                if (!$destiny_zone) {
                    $data['warning'] = 'No se encontró una zona de envío para tu dirección.';
                }

                // Shipping groups by carrier zone (origin->destiny mapping)
                $groups = [];

                foreach ($data['products'] as $item) {
                    // Compute item freight weight (weight * quantity)
                    $item['freight'] = round($item['weight'] * $item['quantity'], 2);

                    // Resolve origin zone from the product's ZIP/colony code
                    $origin_zone = ColonyModel::where('zc', $item['zc'])->value('zone');

                    // Resolve carrier zone using origin + destination zones
                    $zone = CarrierZoneModel::where('origin', $origin_zone)->where('destiny', $destiny_zone)->value('zone');

                    // Add warning when the product has no shipping coverage
                    if (!$zone) {
                        $item['warning'] = 'Producto sin cobertura de envío';

                        $items[] = $item;

                        continue;
                    }

                    // Group products that share the same carrier zone to price shipping once per group
                    if (!isset($groups[$zone])) {
                        $groups[$zone] = ['zone' => $zone, 'weight' => 0.0, 'products' => []];
                    }

                    // Accumulate group total weight and store product rows for proportional split
                    $groups[$zone]['weight'] += $item['freight'];
                    $groups[$zone]['products'][] = $item;
                }

                foreach ($groups as $group) {
                    // Look up shipping price by zone + rounded-up weight bracket
                    $shipping_price = CarrierRateModel::where('zone', $group['zone'])->where('weight', ceil($group['weight']))->value('price');

                    if (!$shipping_price) {
                        foreach ($group['products'] as $item) {
                            $item['warning'] = 'Producto sin tarifa de envío';

                            $items[] = $item;
                        }

                        continue;
                    }

                    // Shipping amount excluding VAT
                    $shipment_total = round(iva_breakdown(floatval($shipping_price)), 2);

                    // Accumulate shipping amount including VAT
                    $data['shipping'] += floatval($shipping_price);

                    $shipment = 0.0;
                    $products = count($group['products']);

                    foreach ($group['products'] as $index => $item) {
                        // Store group shipping metadata at item level (for UI/debug)
                        $item['shipment'] = 0.0;
                        $item['shipping'] = $shipping_price;

                        // Split group shipping among items proportionally by their freight weight
                        $proportion = $item['freight'] / $group['weight'];

                        // Calculate proportional shipment amount
                        $item['shipment'] = round($shipment_total * $proportion, 2);

                        // Adjust last product to absorb rounding differences
                        if ($index === $products - 1) {
                            $item['shipment'] = round($shipment_total - $shipment, 2);
                        }

                        // Accumulate shipment amount for next iterations
                        $shipment += $item['shipment'];

                        // Convert item shipping to per-unit shipping
                        $shipment_unit = round($item['shipment'] / $item['quantity'], 2);

                        // Compute per-unit base price without VAT
                        $item['unit'] = round(iva_breakdown($item['price']), 2);

                        // Build per-unit value including shipping share
                        $item['value'] = round($item['unit'] + $shipment_unit, 2);

                        // Line subtotal (product only, without discount and without VAT)
                        $item['subtotal'] = round($item['unit'] * $item['quantity'], 2);

                        // Line base includes shipping share before discount
                        $item['base'] = round($item['value'] * $item['quantity'], 2);

                        // Line amount after discount (taxable amount)
                        $item['amount'] = round($item['base'] - $item['discount'], 2);

                        // VAT calculated from taxable amount
                        $item['vat'] = round(iva_calculate($item['amount']), 2);

                        // Final line total
                        $item['total'] = round($item['amount'] + $item['vat'], 2);

                        // Accumulate checkout totals
                        $data['freight'] += $item['freight'];
                        $data['shipment'] += $item['shipment'];
                        $data['subtotal'] += $item['subtotal'];
                        $data['amount'] += $item['amount'];
                        $data['vat'] += $item['vat'];
                        $data['total'] += $item['total'];

                        // Push recalculated item back to products list
                        $items[] = $item;
                    }
                }

                // Replace products with recalculated rows (shipping/tax applied)
                $data['products'] = $items;
            }

            // Persist checkout payload to session for the checkout view and next steps
            Session::put('_checkout', $data);
        }

        // Render checkout page using the computed checkout payload
        return view('cart.checkout', compact('data'));
    }

    public function mercadopago()
    {
        $items = [];

        $checkout = Session::get('_checkout');

        $payer['name']  = $checkout['address']['name'];
        $payer['email'] = $checkout['address']['email'];

        foreach ($checkout['products'] as $item) {
            $items[] = [
                'id'          => $item['sku'],
                'title'       => $item['name'],
                'quantity'    => intval($item['quantity']),
                'unit_price'  => floatval($item['price']),
                'currency_id' => 'MXN',
            ];
        }

        $items[] = [
            'id'          => 'shipping',
            'title'       => 'Costo de envío',
            'quantity'    => 1,
            'unit_price'  => floatval($checkout['shipping']),
            'currency_id' => 'MXN',
        ];

        MercadoPagoConfig::setAccessToken(env('MERCADOPAGO_TOKEN'));

        $client = new PreferenceClient();

        $preference = $client->create([
            'items'              => $items,
            'payer'              => $payer,
            'expires'            => true,
            'expiration_date_to' => date('c', strtotime('+24 hours')),
        ]);

        $view = view('cart.mercadopago', compact('checkout', 'preference'));

        return response(['render' => ['overlap-one' => $view->render()]]);
    }

    public function mercadopago_payment(Request $request)
    {
        $invoice = Session::get('_invoice');
        $success = Session::get('_checkout');

        $success['invoice'] = $invoice;
        $success['payment'] = 'Mercado Pago';
        $success['status']  = 'Proceso';

        MercadoPagoConfig::setAccessToken(env('MERCADOPAGO_TOKEN'));

        try {
            $client = new PaymentClient();

            $data = [
                'transaction_amount' => (float) $success['total'],
                'payment_method_id'  => $request->payment_method_id,
                'payer'              => ['email' => $request->input('payer.email')],
            ];

            if ($request->filled('token')) {
                $data['installments'] = (int) $request->installments;
                $data['issuer_id']    = $request->issuer_id;
                $data['token']        = $request->token;
            }

            if ($request->filled('metadata')) {
                $data['metadata'] = $request->metadata;
            }

            $payment = $client->create($data);

            $status      = $payment->status;
            $transaction = $payment->transaction_details;

            $success['payment_id']     = $payment->id;
            $success['payment_status'] = $payment->status;
            $success['payment_detail'] = $payment->status_detail;
            $success['payment_type']   = $payment->payment_type_id;
            $success['payment_method'] = $payment->payment_method_id;

            if ($success['payment_type'] === 'ticket') {
                $success['payment_url']  = $transaction->external_resource_url;
                $success['payment_code'] = $transaction->verification_code;
            }

            if (isset(MERCADOPAGO_STATUS[$success['payment_status']])) {
                $status = MERCADOPAGO_STATUS[$success['payment_status']];
            }

            if (isset(MERCADOPAGO_DETAIL[$success['payment_detail']])) {
                $detail = MERCADOPAGO_DETAIL[$success['payment_detail']];
            }

            if (isset($payment->order->id)) {
                $success['payment_order'] = $payment->order->id;
            }

            if (in_array($payment->status, ['approved', 'authorized', 'pending', 'in_process'], true) === false) {
                throw new Exception($detail ?? $status);
            }
        } catch (MPApiException $e) {
            $response = $e->getApiResponse();
            $message  = $e->getMessage();

            $content = $response->getContent();
            $code    = $response->getStatusCode();

            if (isset($content['message'])) {
                $message = $content['message'];
            }

            if (!empty($content['cause'])) {
                $causes = array_column($content['cause'], 'description');

                if (!empty($causes)) {
                    $message = implode(', ', $causes);
                }
            }

            if (isset(MERCADOPAGO_DETAIL[$message])) {
                $message = MERCADOPAGO_DETAIL[$message];
            }

            return response(['message' => $message], $code);

        } catch (Throwable $e) {
            return response(['message' => $e->getMessage()], 400);
        }

        DB::beginTransaction();

        try {
            $success['folio'] = str_folio(ShippingModel::count(), 'P');

            $create = array_unwrap($success, ['address']);

            $shipping = ShippingModel::create($create);

            foreach ($success['products'] as $item) {
                ShippingProductModel::create(array_merge($item, ['shipping_id' => $shipping->id]));
            }

            DB::commit();

        } catch (Exception $e) {
            DB::rollBack();

            ErrorModel::create(['tag' => 'mercadopago', 'reference' => $success['payment_id'], 'exception' => $e->getMessage()]);

            return response(['message' => 'Tu pago fue recibido correctamente, pero ocurrió un problema al registrar tu pedido. Nuestro equipo revisará la operación. Por favor no intentes realizar el pago nuevamente.'], 500);
        }

        // try {
        //     Mail::send('layouts.messages.success', compact('checkout'), function ($message) use ($success) {
        //         $message->to($success['address']['email'])->cc(env('MAIL_USERNAME'))->subject("Pedido de MCAShop Generado - Folio: {$success['folio']}");
        //     });
        // } catch (Throwable $e) {
        //     ErrorModel::create(['tag' => 'mail', 'reference' => $success['folio'], 'exception' => $e->getMessage()]);
        // }

        Session::regenerateCart();

        Session::forget('_invoice');

        Session::flash('_success', $success);

        return response(['message' => "{$status} Redireccionando..."]);
    }

    public function success()
    {
        return view('cart.success');
    }

    public function wiretransfer()
    {
        $invoice = Session::get('_invoice');

        $checkout = Session::get('_checkout');

        DB::beginTransaction();

        try {
            $folio = str_folio(ShippingModel::count(), 'P');

            $checkout['folio']          = $folio;
            $checkout['invoice']        = $invoice;
            $checkout['payment']        = 'Transferencia';
            $checkout['payment_method'] = 'bank_transfer';
            $checkout['payment_status'] = 'in_process';
            $checkout['payment_type']   = 'bancomer';
            $checkout['status']         = 'Proceso';
            $checkout['comment']        = 'El pedido se pagará por medio de transferencia bancaria directa, sin intermediarios';

            $discount = 0.0;

            $products = count($checkout['products']);

            $checkout['discount'] = round($checkout['amount'] * (DISCOUNT / 100), 2);

            $checkout = array_merge($checkout, array_fill_keys(['amount', 'vat', 'total'], 0.0));

            foreach ($checkout['products'] as $index => &$item) {
                $item['discount'] = round($item['base'] * (DISCOUNT / 100), 2);

                if ($index === $products - 1) {
                    $item['discount'] = round($checkout['discount'] - $discount, 2);
                }

                $discount += $item['discount'];

                $item['amount'] = round($item['base'] - $item['discount'], 2);
                $item['vat']    = round(iva_calculate($item['amount']), 2);
                $item['total']  = round($item['amount'] + $item['vat'], 2);

                $checkout['amount'] += $item['amount'];
                $checkout['vat'] += $item['vat'];
                $checkout['total'] += $item['total'];
            }

            unset($item);

            $checkout['amount'] = round($checkout['amount'], 2);
            $checkout['vat']    = round($checkout['vat'], 2);
            $checkout['total']  = round($checkout['total'], 2);

            $create = array_unwrap($checkout, ['address']);

            $shipping = ShippingModel::create($create);

            foreach ($checkout['products'] as $item) {
                ShippingProductModel::create(array_merge($item, ['shipping_id' => $shipping->id]));
            }

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();

            ErrorModel::create(['tag' => 'wiretransfer', 'reference' => $checkout['folio'], 'exception' => $e->getMessage()]);

            return response(['message' => 'Ocurrió un problema al registrar tu pedido. Por favor intenta nuevamente.'], 500);
        }

        // try {
        //     Mail::send('layouts.messages.success', compact('checkout'), function ($message) use ($checkout) {
        //         $message->to($checkout['address']['email'])->cc(env('MAIL_USERNAME'))->subject("Pedido de MCAShop Generado - Folio: {$checkout['folio']}");
        //     });
        // } catch (Throwable $e) {
        //     ErrorModel::create(['tag' => 'mail', 'reference' => $checkout['folio'], 'exception' => $e->getMessage()]);
        // }

        Session::regenerateCart();

        Session::forget('_invoice');

        return view('cart.wiretransfer');
    }

    public function quote()
    {
        $invoice  = Session::get('_invoice');
        $checkout = Session::get('_checkout');

        DB::beginTransaction();

        try {
            $folio = str_folio(QuoteModel::count(), 'C');

            $checkout['folio']   = $folio;
            $checkout['invoice'] = $invoice;
            $checkout['status']  = 'Proceso';

            $create = array_unwrap($checkout, ['address']);

            $quote = QuoteModel::create($create);

            foreach ($checkout['products'] as $item) {
                QuoteProductModel::create(array_merge($item, ['quote_id' => $quote->id]));
            }

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();

            ErrorModel::create(['tag' => 'quote', 'reference' => $checkout['folio'], 'exception' => $e->getMessage()]);

            return response(['message' => 'Ocurrió un problema al registrar tu cotización. Por favor intenta nuevamente.'], 500);
        }

        // try {
        //     Mail::send('layouts.messages.quote', compact('checkout'), function ($message) use ($checkout) {
        //         $message->to($checkout['address']['email'])->cc(env('MAIL_USERNAME'))->subject("Cotización de MCAShop Generada - Folio: {$checkout['folio']}");
        //     });
        // } catch (Throwable $e) {
        //     ErrorModel::create(['tag' => 'mail', 'reference' => $checkout['folio'], 'exception' => $e->getMessage()]);
        // }

        Session::regenerateCart();

        Session::forget('_invoice');

        return view('cart.quote');
    }

    public function remove($id)
    {
        $products = [];

        foreach (Session::get('_cart.products') as $product) {
            if ($product['id'] != $id) {
                $products[] = $product;
            }
        }

        return $this->calculate($products);
    }

    public function update($id)
    {
        $products = [];
        $quantity = request('quantity');

        foreach (Session::get('_cart.products') as $product) {
            if ($product['id'] == $id) {
                $product['quantity'] = $quantity;
            }

            $products[] = $product;
        }

        return $this->calculate($products);
    }

    private function calculate($products)
    {
        Session::regenerateCart();

        $cart = Session::get('_cart');

        foreach ($products as $item) {

            $item['freight']  = round($item['weight'] * $item['quantity'], 2);
            $item['unit']     = round(iva_breakdown($item['price']), 2);
            $item['value']    = $item['unit'];
            $item['base']     = round($item['value'] * $item['quantity'], 2);
            $item['amount']   = round($item['base'] - $item['discount'], 2);
            $item['charge']   = round($item['price'] * $item['quantity'], 2);
            $item['vat']      = round(iva_calculate($item['amount']), 2);
            $item['total']    = round($item['amount'] + $item['vat'], 2);
            $item['subtotal'] = round($item['unit'] * $item['quantity'], 2);

            $cart['freight'] += $item['freight'];
            $cart['subtotal'] += $item['subtotal'];
            $cart['amount'] += $item['amount'];
            $cart['vat'] += $item['vat'];
            $cart['total'] += $item['total'];

            $cart['products'][] = $item;
        }

        Session::put('_cart', $cart);

        $view = view('cart.products', compact('cart'));

        return response(['render' => ['_cart' => count($cart['products']), 'products-html' => $view->render()]]);
    }
}
