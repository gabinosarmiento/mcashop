<?php

namespace App\Models;

use App\Models\BaseModel;

class ProductAttributeModel extends BaseModel
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
   protected $table = 'up_product_attribute';

   /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
   protected $fillable = ['feature_id', 'attribute_id', 'name', 'value'];

   /**
    * Get the feature associated with the record.
    */
   public function feature()
   {
      return $this->belongsTo('App\Models\ProductFeatureModel', 'feature_id');
   }

   /**
    * Get the attribute associated with the record.
    */
   public function attribute()
   {
      return $this->belongsTo('App\Models\AttributeModel', 'attribute_id');
   }
}