<?php

namespace App\Models;

use App\Models\BaseModel;

class QuoteProductModel extends BaseModel
{
   /**
    * Indicates if the model should be timestamped.
    *
    * @var bool
    */
   public $timestamps = false;

   /**
    * The table associated with the model.
    *
    * @var string
    */
   protected $table = 'quote_product';

   /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
   protected $fillable = ['quote_id', 'product_id', 'sku', 'name', 'brand', 'quantity', 'weight', 'freight', 'supplier', 'location', 'stock', 'cost', 'markup', 'unit', 'price', 'value', 'subtotal', 'amount', 'discount', 'base', 'vat', 'total', 'shipment'];

   /**
    * Get the products associated with the cat marcas.
    */
   public function product()
   {
      return $this->belongsTo('App\Models\ProductModel', 'product_id');
   }
}
