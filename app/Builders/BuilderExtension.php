<?php

namespace App\Builders;

use Illuminate\Database\Eloquent\Builder;

class BuilderExtension extends Builder
{
    public function withNested($relations)
    {
        $expanded = [];

        if (!is_array($relations)) {
            $relations = func_get_args();
        }

        foreach ($relations as $relation) {
            $relation = trim($relation);

            if (str_contains($relation, ':')) {
                [$parent, $children] = explode(':', $relation, 2);
                $children            = array_map('trim', explode(',', $children));

                foreach ($children as $child) {
                    $expanded[] = $parent . '.' . $child;
                }

                continue;
            }

            $expanded[] = $relation;
        }

        return $this->with($expanded);
    }

    public function withWhere($relations, $conditions = [], $nested = '')
    {
        if (is_string($relations)) {
            $relations = [
                $relations => $conditions,
            ];
        }

        foreach ($relations as $relation => $params) {
            if (!is_array($params[0] ?? null)) {
                $params = [$params];
            }

            $this->whereHas($relation, function ($query) use ($params) {
                foreach ($params as $condition) {
                    $this->condition($query, $condition);
                }
            });

            $this->with([
                $relation => function ($query) use ($params, $nested) {
                    foreach ($params as $condition) {
                        $this->condition($query, $condition);
                    }

                    if ($nested) {
                        $query->with($nested);
                    }
                },
            ]);
        }

        return $this;
    }

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

    public function condition($query, $parameter)
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
