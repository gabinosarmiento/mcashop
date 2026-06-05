<?php

namespace App\Models;

use App\Models\BaseModel;
use App\Models\ProductModel;
use App\Models\ProductRelationModel;
use App\Models\SupplierModel;

class InventoryIndexModel extends BaseModel
{
   /**
    * The table associated with the model.
    *
    * @var string
    */
   protected $table = 'inventory_index';

   /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
   protected $fillable = ['relation_id', 'product_id', 'supplier_id', 'stock', 'price', 'status'];

   /**
    * Get the relation associated with the record.
    */
   public function relation()
   {
      return $this->belongsTo(ProductRelationModel::class, 'relation_id');
   }

   /**
    * Get the product associated with the record.
    */
   public function product()
   {
      return $this->belongsTo(ProductModel::class, 'product_id');
   }

   /**
    * Get the supplier associated with the record.
    */
   public function supplier()
   {
      return $this->belongsTo(SupplierModel::class, 'supplier_id');
   }
}