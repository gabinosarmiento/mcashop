<?php

namespace App\Models;

use App\Models\BaseModel;

class SearchModel extends BaseModel
{
   /**
    * The table associated with the model.
    *
    * @var string
    */
   protected $table = 'search';

   /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
   protected $fillable = ['term', 'hit'];
}