<?php

namespace App\Models;

use App\Builders\BuilderExtension;
use Illuminate\Database\Eloquent\Model;

abstract class BaseModel extends Model
{
   /**
    * Override the method to use BuilderExtension.
    *
    * @param \Illuminate\Database\Query\Builder $query
    * @return \App\QueryBuilders\BuilderExtension
    */
   public function newEloquentBuilder($query)
   {
      return new BuilderExtension($query);
   }
}