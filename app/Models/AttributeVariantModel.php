<?php

namespace App\Models;

use App\Models\BaseModel;

class AttributeVariantModel extends BaseModel
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
   protected $table = 'attribute_variant';

   /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
   protected $fillable = ['attribute_id', 'name'];

   /**
    * Get the supplier associated with the record.
    */
   public function attribute()
   {
      return $this->belongsTo('App\Models\AttributeModel', 'attribute_id');
   }
}