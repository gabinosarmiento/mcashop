<?php

namespace App\Models;

use App\Models\BaseModel;

class ProductInventoryModel extends BaseModel
{
    /**
     * The name of the "created at" column.
     *
     * @var string
     */
    const CREATED_AT = null;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'product_inventory';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['relation_id', 'location', 'zc', 'stock', 'markup', 'cost', 'price', 'special', 'promotion', 'available', 'slogan', 'launch', 'expire', 'created'];

    /**
     * Get the relation associated with the record.
     */
    public function relation()
    {
        return $this->belongsTo('App\Models\ProductRelationModel', 'relation_id');
    }

    /**
     * Get the financing records associated with the inventory.
     */
    public function financing()
    {
        return $this->hasMany('App\Models\ProductFinancingModel', 'inventory_id');
    }
}
