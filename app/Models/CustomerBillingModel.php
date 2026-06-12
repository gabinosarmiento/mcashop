<?php

namespace App\Models;

use App\Models\BaseModel;

class CustomerBillingModel extends BaseModel
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'customer_billing';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['customer_id', 'rfc', 'name', 'phone', 'email', 'regime', 'zc', 'status'];

    /**
     * Set the billing email for the customer.
     *
     * @param  string  $value
     * @return void
     */
    public function setRfcAttribute($value)
    {
        $this->attributes['rfc'] = strtoupper($value);
    }
}
