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

        // if (isset($data['inventory']['price'])) {
        //    if (empty($data['inventory']['financing'])) {
        //       $data['inventory']['financing'] = $this->financing($data['inventory']['price']);

        //       foreach ($data['inventory']['financing'] as $term) {
        //          $term['inventory_id'] = $data['inventory']['id'];

        //          $financing = ProductFinancingModel::create($term);

        //          foreach ($term['installments'] as $installment) {
        //             $installment['financing_id'] = $financing['id'];

        //             ProductInstallmentModel::create($installment);
        //          }
        //       }
        //    }
        // }

        return view('store.product', compact('data'));
    }

    public function brands()
    {
        $data['alphabet'] = [];

        $data['menu'] = $this->menu_categories();

        $brands = BrandModel::has('products.inventory')->hasWhere('products', ['status', 'Activo'])->where('status', 'Activo')->orderByRaw('name regexp "^[0-9]"')->orderBy('name')->get()->toArray();

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
        $products = ProductModel::has('inventory')->with('brand', 'inventory', 'category.features.attributes', 'features.attributes.attribute')->where('brand_id', $brand)->where('status', 'Activo');

        $data['brand'] = BrandModel::find($brand)->toArray();

        $data['menu'] = $this->menu_categories();

        $data['filter'] = $this->brand_filter($products->get());

        // $data['categories'] = $request->input('categories');

        if ($request->categories) {
            $products->whereIn('category_id', $request->categories);
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

                $products->orderByRaw("(select min(i.price) from product_inventory i inner join product_relation r on i.relation_id = r.id where r.product_id = product.id and i.created = curdate()) {$order}");
            }
        }

        $products = $products->paginate($contador)->appends($request->only('categories', 'order'))->toArray();

        $data = array_merge($data, $products);

        // $products = $products->paginate($contador)->appends($request->only('categories', 'order'));
        // $data = array_merge($data, ['data' => $products]);

        // dd($data);

        return view('store.brand', compact('data'));
    }

    public function brand_filter($data)
    {
        $submenu    = [];
        $categories = [];

        foreach ($data as $product) {
            if (!isset($categories[$product->category->id])) {
                $submenu[] = ['id' => $product->category->id, 'value' => $product->category->name];

                $categories[$product->category->id] = true;
            }
        }

        $filters = [['id' => '1', 'name' => 'Categorías', 'submenu' => $submenu]];

        return $filters;
    }

    public function category(Request $request, $category, $name, $contador = 18)
    {
        $products = ProductModel::has('inventory')->with('brand', 'inventory', 'category.features.attributes', 'features.attributes.attribute')->where('category_id', $category)->where('status', 'Activo');

        $category = CategoryModel::withWhere('features.attributes', ['showcase', 1])->find($category);

        $showcase = $category->features->pluck('attributes')->flatten()->pluck('attribute_id')->unique()->values()->toArray();

        $data['category'] = $category->toArray();

        $data['menu'] = $this->menu_categories();

        // $data['filters'] = $request->input('filters');
        // $data['breadcrumbs'] = $this->crumb_category($category);

        $data['filter'] = $this->category_filter($products->get(), $showcase);

        if ($request->filters) {
            foreach ($request->filters as $attribute => $values) {
                if ($attribute === 'brand') {
                    $brands = $values;

                    continue;
                }

                $attributes[$attribute] = $values;
            }

            if (isset($attributes)) {
                foreach ($attributes as $attributeId => $values) {
                    $products->hasWhere('features.attributes', ['attribute_id', $attributeId])->hasWhere('features.attributes', ['value', 'in', $values]);
                }
            }

            if (!empty($brands)) {
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

                $products->orderByRaw("(select min(i.price) from product_inventory i inner join product_relation r on i.relation_id = r.id where r.product_id = product.id and i.created = curdate()) {$order}");
            }
        }

        $products = $products->paginate($contador)->appends($request->only('filters', 'order'))->toArray();

        $data = array_merge($data, $products);

        return view('store.category', compact('data'));
    }

    public function category_filter($products, $showcase)
    {
        $filters = [];
        $index   = [];

        $brands = ['B' => ['id' => 'brand', 'name' => 'Marca', 'submenu' => []]];

        foreach ($products as $product) {
            $brands['B']['submenu'][$product->brand->id] = [
                'value' => $product->brand->name,
            ];

            foreach ($product->features as $feature) {
                foreach ($feature->attributes as $item) {

                    if (!in_array($item->attribute_id, $showcase)) {
                        continue;
                    }

                    if (!isset($filters[$item->attribute_id])) {
                        $filters[$item->attribute_id] = [
                            'id'      => $item->attribute->id,
                            'name'    => $item->attribute->name,
                            'submenu' => [],
                        ];
                    }

                    if (isset($index[$item->attribute_id][$item->value])) {
                        continue;
                    }

                    $index[$item->attribute_id][$item->value] = true;

                    $filters[$item->attribute_id]['submenu'][] = [
                        'value' => $item->value,
                    ];
                }
            }
        }

        uasort($brands['B']['submenu'], function ($a, $b) {
            return $a['value'] <=> $b['value'];
        });

        uasort($filters, function ($a, $b) {
            return $a['name'] <=> $b['name'];
        });

        foreach (array_keys($filters) as $key) {
            usort($filters[$key]['submenu'], function ($a, $b) {
                return $a['value'] <=> $b['value'];
            });
        }

        return array_merge($brands, $filters);
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

    public function menu_categories()
    {
        $menu  = [];
        $items = [];

        $categories = CategoryModel::where('status', 'Activo')->orderBy('name')->get();

        foreach ($categories as $category) {
            $parent = $category->parent_id;

            if (!isset($items[$parent])) {
                $items[$parent] = [];
            }

            $items[$parent][] = $category;
        }

        function buildItem($items, $parent = null)
        {
            $menu = [];

            if (isset($items[$parent])) {
                foreach ($items[$parent] as $category) {
                    $children = buildItem($items, $category->id);

                    if ($category->node == 1 && $category->menu == 1) {
                        $menu[] = ['id' => $category->id, 'name' => $category->name, 'submenu' => []];
                        continue;
                    }

                    if (!empty($children)) {
                        $menu[] = ['id' => $category->id, 'name' => $category->name, 'submenu' => $children];
                    }
                }
            }

            return $menu;
        }

        return buildItem($items);
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
