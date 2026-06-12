<?php

namespace App\Models;

use App\Models\BaseModel;

class SupplierModel extends BaseModel
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'supplier';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['rfc', 'code', 'name', 'contact', 'phone', 'email', 'term', 'amount', 'due', 'priority', 'parity', 'status'];

    /**
     * Get the store records associated with the record.
     */
    public function stores()
    {
        return $this->hasMany('App\Models\SupplierStoreModel', 'supplier_id');
    }

    /**
     * Get the relations associated with the supplier.
     */
    public function relations()
    {
        return $this->hasMany('App\Models\ProductRelationModel', 'supplier_id');
    }
}
