<?php

namespace App\Models;

use App\Models\BaseModel;

class CustomerAddressModel extends BaseModel
{
    /**
     * The table name.
     *
     * @var string
     */
    protected $table = 'customer_address';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['customer_id', 'name', 'company', 'phone', 'email', 'street', 'streets', 'apartment', 'reference', 'colony', 'municipality', 'city', 'state', 'country', 'zc'];
}