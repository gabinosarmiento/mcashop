<?php

namespace App\Models;

use App\Models\BaseModel;

class ShippingModel extends BaseModel
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'shipping';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['customer_id', 'folio', 'name', 'email', 'phone', 'street', 'streets', 'reference', 'colony', 'city', 'state', 'country', 'zc', 'shipment', 'shipping', 'subtotal', 'amount', 'discount', 'saving', 'vat', 'total', 'payment', 'payment_id', 'payment_method', 'payment_type', 'payment_order', 'payment_status', 'payment_detail', 'freight', 'tracking', 'tracking_link', 'tracking_track', 'comment', 'invoice', 'status'];

    /**
     * Get the customer associated to this shipment.
     */
    public function customer()
    {
        return $this->belongsTo('App\Models\CustomerModel', 'customer_id');
    }

    /**
     * Get the products associated with the shipment.
     */
    public function products()
    {
        return $this->hasMany('App\Models\ShippingProductModel', 'shipping_id');
    }
}
