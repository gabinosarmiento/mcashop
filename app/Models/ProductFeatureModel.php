<?php

namespace App\Models;

use App\Models\BaseModel;

class ProductFeatureModel extends BaseModel
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
   protected $table = 'up_product_feature';

   /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
   protected $fillable = ['product_id', 'feature_id', 'name'];

   /**
    * Get the product associated with the record.
    */
   public function product()
   {
      return $this->belongsTo('App\Models\ProductModel', 'product_id');
   }

   /**
    * Get the feature associated with the record.
    */
   public function feature()
   {
      return $this->belongsTo('App\Models\FeatureModel', 'feature_id');
   }

   /**
    * Get related attribute entries associated with the record.
    */
   public function attributes()
   {
      return $this->hasMany('App\Models\ProductAttributeModel', 'feature_id');
   }
}