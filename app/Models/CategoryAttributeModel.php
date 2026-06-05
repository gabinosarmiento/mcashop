<?php

namespace App\Models;

use App\Models\BaseModel;

class CategoryAttributeModel extends BaseModel
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
   protected $table = 'category_attribute';

   /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
   protected $fillable = ['feature_id', 'attribute_id', 'showcase', 'sort'];

   /**
    * Get the feature that owns the record.
    */
   public function feature()
   {
      return $this->belongsTo('App\Models\CategoryFeatureModel', 'feature_id');
   }

   /**
    * Get the attribute that owns the record.
    */
   public function attribute()
   {
      return $this->belongsTo('App\Models\AttributeModel', 'attribute_id');
   }
}