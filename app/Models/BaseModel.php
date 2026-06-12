<?php

namespace App\Models;

use DateTimeInterface;
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

   protected function serializeDate(DateTimeInterface $date): string
   {
      return $date->format('Y-m-d H:i:s');
   }
}