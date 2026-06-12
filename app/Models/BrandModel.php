<?php

namespace App\Models;

use App\Models\BaseModel;
use App\Models\BrandVariantModel;
use App\Models\ProductModel;

class BrandModel extends BaseModel
{
   /**
    * The table associated with the model.
    *
    * @var string
    */
   protected $table = 'brand';

   /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
   protected $fillable = ['image', 'name', 'web', 'menu', 'description', 'status'];

   /**
    * Get the variants associated with the brand.
    */
   public function variants()
   {
      return $this->hasMany(BrandVariantModel::class, 'brand_id');
   }

   /**
    * Get the products associated with the brand.
    */
   public function products()
   {
      return $this->hasMany(ProductModel::class, 'brand_id');
   }
}