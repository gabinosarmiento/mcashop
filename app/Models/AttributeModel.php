<?php

namespace App\Models;

use App\Models\BaseModel;

class AttributeModel extends BaseModel
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
   protected $table = 'attribute';

   /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
   protected $fillable = ['icecat', 'name'];

   /**
    * Get related attribute entries based on the mca_template.
    */
   public function variants()
   {
      return $this->hasMany('App\Models\AttributeVariantModel', 'attribute_id');
   }
}
