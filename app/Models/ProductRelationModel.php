<?php

namespace App\Models;

use App\Models\BaseModel;

class ProductRelationModel extends BaseModel
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'product_relation';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['product_id', 'supplier_id', 'code', 'sku', 'name', 'subname'];

    /**
     * Get the supplier associated with the record.
     */
    public function product()
    {
        return $this->belongsTo('App\Models\ProductModel', 'product_id');
    }

    /**
     * Get the supplier associated with the record.
     */
    public function supplier()
    {
        return $this->belongsTo('App\Models\SupplierModel', 'supplier_id');
    }

    /**
     * Get the inventories records associated with the record.
     */
    public function inventories()
    {
        return $this->hasMany('App\Models\ProductInventoryModel', 'relation_id')->withoutGlobalScope('we_created');
    }
}
