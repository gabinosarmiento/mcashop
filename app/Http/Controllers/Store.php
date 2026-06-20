<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\BrandModel;
use App\Models\CategoryModel;
use App\Models\CategoryRelationModel;
use App\Models\ProductModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class Store extends Controller
{
    public function product($id)
    {
        $this->recently_data($id);

        $data = ProductModel::withNested('brand', 'images', 'inventory', 'features:feature,attributes.attribute')->whereIn('status', ['Activo', 'Pausado'])->findOrFail($id)->toArray();

        $category = CategoryModel::find($data['category_id']);

        $data['showcase'] = $this->show_attributes($category);

        $data['breadcrumbs'] = $this->crumb_category($category);

        $data['category'] = $category->toArray();

        $data['menu'] = $this->menu_categories();

        $data['breadcrumbs'] = $this->crumb_category($category);

        $category_related = CategoryRelationModel::where('category_id', $data['category_id'])->pluck('relation_id')->toArray();

        $data['category_related'] = ProductModel::has('inventory')->with('brand', 'inventory')->whereIn('category_id', $category_related)->where('status', 'Activo')->where('id', '!=', $data['id'])->inRandomOrder()->limit(6)->get()->toArray();

        $category_software = CategoryModel::where('parent_id', 171)->pluck('id')->toArray();

        $data['category_software'] = ProductModel::has('inventory')->with('brand', 'inventory')->whereIn('category_id', $category_software)->where('status', 'Activo')->where('id', '!=', $data['id'])->inRandomOrder()->limit(6)->get()->toArray();

        $product_recently = Session::get('_recently');

        $data['product_recently'] = ProductModel::has('inventory')->with('brand', 'inventory')->whereIn('id', $product_recently)->where('status', 'Activo')->where('id', '!=', $data['id'])->inRandomOrder()->limit(6)->get()->toArray();

        $data['product_related'] = ProductModel::has('inventory')->with('brand', 'inventory')->where('category_id', $data['category_id'])->where('status', 'Activo')->where('id', '!=', $data['id'])->inRandomOrder()->limit(6)->get()->toArray();

        return view('store.product', compact('data'));
    }

    public function brands()
    {
        $data['alphabet'] = [];

        $data['menu'] = $this->menu_categories();

        $brands = BrandModel::where('status', 'Activo')->where('menu', 1)->orderByRaw('name regexp "^[0-9]"')->orderBy('name')->get()->toArray();

        foreach ($brands as $brand) {
            $letter = strtoupper(substr($brand['name'], 0, 1));

            if (array_key_exists($letter, $data['alphabet'])) {
                $data['alphabet'][$letter][] = $brand;

                continue;
            }

            $data['alphabet'][$letter][] = $brand;
        }

        return view('store.brands', compact('data'));
    }

    public function brand(Request $request, $brand, $name, $contador = 18)
    {
        $data = BrandModel::find($brand)->toArray();

        $products = ProductModel::has('inventory')->with('brand', 'inventory', 'category.features.attributes', 'features.attributes.attribute')->where('brand_id', $brand)->where('status', 'Activo');

        $data['filters'] = $this->brand_filter($request, $products->get());

        $data['menu'] = $this->menu_categories();

        if ($request->filter) {
            $categories = [];
            foreach ($request->filter as $values) {
                foreach ($values as $value) {
                    $categories[] = $value;
                }
            }

            if ($categories) {
                $products->hasWhere('category', ['name', 'in', $categories]);
            }
        }

        if ($request->order) {
            if (in_array($request->order, ['asc', 'desc'])) {
                $products->orderBy('name', $request->order);
            }

            if (in_array($request->order, ['low', 'high'])) {
                $order = 'asc';

                if ($request->order == 'high') {
                    $order = 'desc';
                }

                $products->orderByRaw("(select i.price from inventory_index i where i.product_id = product.id) {$order}");
            }
        }

        $products = $products->paginate($contador)->appends($request->only('category', 'order'));

        foreach ($products as $product) {
            $showcase = [];

            foreach ($product->category->features as $feature) {
                foreach ($feature->attributes as $attribute) {
                    if ($attribute->showcase == 1) {
                        $showcase[] = $attribute->attribute_id;
                    }
                }
            }

            $product->setAttribute('showcase', $showcase);
        }

        $data = array_merge($data, $products->toArray());

        return view('store.brand', compact('data'));
    }

    public function category(Request $request, $category, $name, $contador = 18)
    {
        $data = CategoryModel::with('features.attributes.attribute')->find($category)->toArray();

        $showcase = [];
        foreach ($data['features'] as $feature) {
            foreach ($feature['attributes'] as $attribute) {
                if ($attribute['showcase'] == 1) {
                    $showcase[] = $attribute['attribute_id'];
                }
            }
        }

        $products = ProductModel::has('inventory')->with('brand', 'inventory', 'features.attributes.attribute')->where('category_id', $category)->where('status', 'Activo');

        $data['filters'] = $this->category_filter($request, $showcase, $products->get());

        $data['menu'] = $this->menu_categories();

        if ($request->filter) {
            foreach ($request->filter as $attribute => $values) {
                if ($attribute === 'brand') {
                    $brands = $values;
                }

                if ($attribute !== 'brand') {
                    $attributes[$attribute] = $values;
                }
            }

            if (isset($attributes)) {
                foreach ($attributes as $attributeId => $values) {
                    $products->hasWhere('features.attributes', ['attribute_id', $attributeId])->hasWhere('features.attributes', ['value', 'in', $values]);
                }
            }

            if (isset($brands)) {
                $products->hasWhere('brand', ['name', 'in', $brands]);
            }
        }

        if ($request->order) {
            if (in_array($request->order, ['asc', 'desc'])) {
                $products->orderBy('name', $request->order);
            }

            if (in_array($request->order, ['low', 'high'])) {
                $order = 'asc';

                if ($request->order == 'high') {
                    $order = 'desc';
                }

                $products->orderByRaw("(select i.price from inventory_index i where i.product_id = product.id) {$order}");
            }
        }

        $products = $products->paginate($contador)->appends($request->only('filter', 'order'));

        foreach ($products as $product) {
            $product->setAttribute('showcase', $showcase);
        }

        $data = array_merge($data, $products->toArray());

        return view('store.category', compact('data'));
    }

    protected function category_filter($request, $showcase, $products)
    {
        $filters      = [];
        $filter_index = [];
        $value_index  = [];
        $brand_index  = [];

        $brands = ['B' => ['id' => 'brand', 'name' => 'Marca', 'count' => 0, 'submenu' => []]];

        foreach ($products as $product) {
            if (empty($brand_index[$product->brand->id])) {
                $checked = false;

                if ($request->filter) {
                    if (isset($request->filter['brand'])) {
                        if (in_array($product->brand->name, $request->filter['brand'])) {
                            $checked = true;
                            $brands['B']['count']++;
                        }
                    }
                }

                $brands['B']['submenu'][] = ['value' => $product->brand->name, 'checked' => $checked];

                $brand_index[$product->brand->id] = true;
            }

            foreach ($product->features as $feature) {
                foreach ($feature->attributes as $item) {
                    if (in_array($item->attribute_id, $showcase)) {

                        if (empty($filter_index[$item->attribute_id])) {
                            $filters[] = ['id' => $item->attribute->id, 'name' => $item->attribute->name, 'count' => 0, 'submenu' => []];

                            $filter_index[$item->attribute_id] = count($filters) - 1;
                        }

                        $key = $filter_index[$item->attribute_id];

                        if (empty($value_index[$item->attribute_id][$item->value])) {
                            $checked = false;

                            if ($request->filter) {
                                if (isset($request->filter[$item->attribute_id])) {
                                    if (in_array($item->value, $request->filter[$item->attribute_id])) {
                                        $checked = true;
                                        $filters[$key]['count']++;
                                    }
                                }
                            }

                            $value_index[$item->attribute_id][$item->value] = true;

                            $filters[$key]['submenu'][] = ['value' => $item->value, 'checked' => $checked];
                        }
                    }
                }
            }
        }

        $filters = array_sort($filters, 'name');

        $brands['B']['submenu'] = array_sort($brands['B']['submenu'], 'value');

        foreach (array_keys($filters) as $key) {
            $filters[$key]['submenu'] = array_sort($filters[$key]['submenu'], 'value');
        }

        return array_merge($brands, $filters);
    }

    protected function brand_filter($request, $data)
    {
        $category_index = [];

        $categories = ['C' => ['id' => 1, 'name' => 'Categorías', 'count' => 0, 'submenu' => []]];

        foreach ($data as $product) {
            if (empty($category_index[$product->category->id])) {
                $checked = false;

                if ($request->filter) {
                    if (isset($request->filter[$categories['C']['id']])) {
                        if (in_array($product->category->name, $request->filter[$categories['C']['id']])) {
                            $checked = true;
                            $categories['C']['count']++;
                        }
                    }
                }

                $categories['C']['submenu'][] = ['value' => $product->category->name, 'checked' => $checked];

                $category_index[$product->category->id] = true;
            }
        }

        $categories['C']['submenu'] = array_sort($categories['C']['submenu'], 'value');

        return $categories;
    }

    protected function crumb_category($data)
    {
        $breadcrumbs = [];

        while ($data) {
            $breadcrumbs[] = ['id' => $data->id, 'name' => $data->name];

            $data = $data->parent;
        }

        return array_reverse($breadcrumbs);
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

    protected function recently_data($product)
    {
        $products = Session::get('_recently');

        if (!in_array($product, $products)) {
            $products[] = $product;

            Session::put('_recently', $products);
        }
    }
}
