<?php

namespace App\Services;

use App\Models\ProductModel;
use App\Models\SearchBlacklistModel;
use App\Models\SearchModel;
use App\Models\SearchSynonymModel;
use Illuminate\Http\Request;

class SearchService
{
    protected $perPage = 100;

    public function searchQuery(Request $request, int $page = 1)
    {
        $terms = str_clean($request->param);
        $terms = mb_strtolower($terms, 'UTF-8');
        $terms = explode(' ', $terms);
        $terms = array_values(array_filter($terms));

        $data = $this->removeBlacklisted($terms);

        if (empty($data)) {
            return [];
        }

        $this->logSearch(implode(' ', $data));

        $synonyms = $this->synonymsMap($data);

        $query = $this->baseQuery($synonyms);

        $exists = $query->exists();

        if ($exists === false) {
            $query = $this->baseQueryLoose($synonyms);
        }

        $this->applyFilters($query, $request);

        $this->applyOrder($query, $request);

        $results = $query->limit($this->perPage)->get();

        $data['search'] = $results->toArray();

        $data['filter'] = $this->search_filter($results);

        return $data;
    }

    protected function applyFilters($query, Request $request)
    {
        $brands     = [];
        $attributes = [];

        if (!$request->filters) {
            return;
        }

        foreach ($request->filters as $attribute => $values) {
            if ($attribute === 'brand') {
                $brands = $values;
                continue;
            }

            $attributes[$attribute] = $values;
        }

        if (!empty($brands)) {
            $query->hasWhere('brand', ['name', 'in', $brands]);
        }

        foreach ($attributes as $attributeId => $values) {
            $query->hasWhere('features.attributes', ['attribute_id', $attributeId])->hasWhere('features.attributes', ['value', 'in', $values]);
        }
    }

    protected function applyOrder($query, Request $request)
    {
        if (!$request->order) {
            return;
        }

        if (in_array($request->order, ['asc', 'desc'])) {
            $query->orderBy('product.name', $request->order);
            return;
        }

        if (!in_array($request->order, ['low', 'high'])) {
            return;
        }

        $order = 'asc';

        if ($request->order === 'high') {
            $order = 'desc';
        }

        $query->orderByRaw("(select i.price from inventory_index i where i.product_id = product.id) {$order}");
    }

    public function search_filter($products)
    {
        $filter   = [];
        $submenu  = [];
        $showcase = [];

        $brands = ['B' => ['id' => 'brand', 'name' => 'Marca', 'submenu' => []]];

        foreach ($products as $product) {

            if ($product->brand && !isset($brands['B']['submenu'][$product->brand->id])) {
                $brands['B']['submenu'][$product->brand->id] = [
                    'id'        => $product->brand->id,
                    'attribute' => 'marca',
                    'value'     => $product->brand->name,
                ];
            }

            if (!isset($showcase[$product->category_id])) {
                $showcase[$product->category_id] = $this->show_attributes($product->category);
            }

            $show = $showcase[$product->category_id];

            foreach ($product->features as $feature) {
                foreach ($feature->attributes as $item) {

                    if (!in_array($item->attribute_id, $show)) {
                        continue;
                    }

                    if (!isset($filter[$item->attribute_id])) {
                        $filter[$item->attribute_id] = [
                            'id'      => $item->attribute->id,
                            'name'    => $item->attribute->name,
                            'submenu' => [],
                        ];
                    }

                    if (!isset($submenu[$item->attribute_id][$item->value])) {
                        $submenu[$item->attribute_id][$item->value] = true;

                        $filter[$item->attribute_id]['submenu'][] = [
                            'value' => $item->value,
                        ];
                    }
                }
            }
        }

        uasort($brands['B']['submenu'], function ($a, $b) {
            return $a['value'] <=> $b['value'];
        });

        uasort($filter, function ($a, $b) {
            return $a['name'] <=> $b['name'];
        });

        foreach (array_keys($filter) as $key) {
            usort($filter[$key]['submenu'], function ($a, $b) {
                return $a['value'] <=> $b['value'];
            });
        }

        return array_merge($brands, $filter);
    }

    protected function baseQuery(array $synonyms)
    {
        $products = ProductModel::with(['brand', 'category'])->where('status', 'Activo')->whereHas('inventory');

        if (!empty($synonyms['product'])) {
            $products->where(function ($query) use ($synonyms) {
                $terms = $synonyms['product'];

                $query->where(function ($subquery) use ($terms) {
                    foreach ($terms as $term) {
                        $subquery->orWhere('sku', 'like', "%{$term}%")->orWhere('name', 'like', "%{$term}%")->orWhere('subname', 'like', "%{$term}%");
                    }
                });
            });
        }

        if (!empty($synonyms['category'])) {
            $products->hasWhere('category', ['name', 'likeAny', $synonyms['category']]);
        }

        if (!empty($synonyms['brand'])) {
            $products->hasWhere('brand', ['name', 'likeAny', $synonyms['brand']]);
        }

        return $products;
    }

    protected function baseQueryLoose(array $synonyms)
    {
        $products = ProductModel::with(['brand', 'category', 'cover'])->where('status', 'Activo');

        $products->where(function ($query) use ($synonyms) {
            if (!empty($synonyms['product'])) {
                foreach ($synonyms['product'] as $term) {
                    $query->orWhere('sku', 'like', "%{$term}%")->orWhere('name', 'like', "%{$term}%")->orWhere('subname', 'like', "%{$term}%");
                }
            }

            if (!empty($synonyms['category'])) {
                $query->orWhereHas('category', function ($subquery) use ($synonyms) {
                    apply_condition($subquery, ['name', 'likeAny', $synonyms['category']]);
                });
            }
        });

        if (!empty($synonyms['brand'])) {
            $products->hasWhere('brand', ['name', 'likeAny', $synonyms['brand']]);
        }

        return $products;
    }

    protected function synonymsMap(array $terms): array
    {
        $data = [];

        $rows = SearchSynonymModel::whereIn('term', $terms)->orderByDesc('score')->get()->groupBy('term');

        foreach ($terms as $term) {
            if (!isset($rows[$term])) {
                $data['product'][$term] = true;
                continue;
            }

            foreach ($rows[$term] as $row) {
                $data[$row->base][$row->synonym] = true;
            }
        }

        foreach ($data as $base => $items) {
            $data[$base] = array_keys($items);
        }

        return $data;
    }

    protected function removeBlacklisted(array $words): array
    {
        $blocked = SearchBlacklistModel::whereIn('word', $words)->pluck('word')->toArray();

        $allowed = array_diff($words, $blocked);

        return $allowed;
    }

    protected function logSearch(string $term): void
    {
        $search = SearchModel::where('term', $term)->first();

        if ($search) {
            $search->increment('hit');
            return;
        }

        SearchModel::create(['term' => $term, 'hit' => 1]);
    }

    protected function show_attributes($data)
    {
        $features = [];

        foreach ($data->features as $feature) {
            foreach ($feature->attributes as $attribute) {

                if ($attribute->showcase === 1) {
                    $features[] = $attribute->attribute_id;
                }
            }
        }

        return $features;
    }
}
