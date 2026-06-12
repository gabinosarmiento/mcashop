<?php

namespace App\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Builder;

class QuoteModel extends BaseModel
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'quote';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['administrative_id', 'customer_id', 'folio', 'name', 'company', 'email', 'phone', 'street', 'streets', 'reference', 'colony', 'city', 'state', 'country', 'zc', 'payment', 'surcharge', 'subtotal', 'amount', 'vat', 'total', 'freight', 'shipment', 'invoice', 'comment', 'status'];

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::creating(function ($model) {
            if (auth('administrative')->check()) {
                $model->administrative_id = auth('administrative')->id();
            }
        });
    }

    /**
     * Get the customer associated to this quote.
     */
    public function customer()
    {
        return $this->belongsTo('App\Models\CustomerModel', 'customer_id');
    }

    /**
     * Get the administrative associated to this quote.
     */
    public function administrative()
    {
        return $this->belongsTo('App\Models\AdministrativeModel', 'administrative_id');
    }

    /**
     * Get the products associated with the cat marcas.
     */
    public function products()
    {
        return $this->hasMany('App\Models\QuoteProductModel', 'quote_id');
    }
}
