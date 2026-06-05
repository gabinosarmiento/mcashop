<?php

namespace App\Models;

use App\Models\BaseModel;

class CategoryFeatureModel extends BaseModel
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
   protected $table = 'category_feature';

   /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
   protected $fillable = ['category_id', 'feature_id'];

   /**
    * Get the category that owns the record.
    */
   public function category()
   {
      return $this->belongsTo('App\Models\CategoryModel', 'category_id');
   }

   /**
    * Get the feature that owns the record.
    */
   public function feature()
   {
      return $this->belongsTo('App\Models\FeatureModel', 'feature_id');
   }

   /**
    * Get the attributes associated with the category.
    */
   public function attributes()
   {
      return $this->hasMany('App\Models\CategoryAttributeModel', 'feature_id');
   }
}