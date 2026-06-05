<?php

namespace App\Builders;

use Illuminate\Database\Eloquent\Builder;

/**
 * Custom Eloquent builder with helper methods for
 * eager-loading and relationship filtering.
 */
class BuilderExtension extends Builder
{
   public function hasWhere($relation, $parameters)
   {
      $parameter = $parameters[0] ?? false;

      if (is_array($parameter) === false) {
         $parameters = [$parameters];
      }

      return $this->whereHas($relation, function ($query) use ($parameters) {
         foreach ($parameters as $parameter) {
            $this->condition($query, $parameter);
         }
      });
   }

   function condition($query, $parameter)
   {
      if (count($parameter) === 2) {
         $parameter = [$parameter[0], '=', $parameter[1]];
      }

      [$column, $operator, $value] = $parameter;

      if ($operator === 'in') {
         return $query->whereIn($column, $value);
      }

      if ($operator === 'notIn') {
         return $query->whereNotIn($column, $value);
      }

      if ($operator === 'likeAny') {
         return $query->where(function ($q) use ($column, $value) {
            foreach ($value as $term) {
               $q->orWhere($column, 'like', "%{$term}%");
            }
         });
      }

      if (strpos($column, ',') !== false) {
         return $query->whereRaw("concat_ws(' ', {$column}) {$operator} ?", [$value]);
      }

      return $query->where($column, $operator, $value);
   }
}