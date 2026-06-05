<?php

namespace App\Models;

use App\Models\BaseModel;

class ProductImageModel extends BaseModel
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
   protected $table = 'product_image';

   /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
   protected $fillable = ['product_id', 'name'];
}