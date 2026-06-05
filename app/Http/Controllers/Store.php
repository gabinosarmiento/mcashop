<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\BrandModel;
use App\Models\CategoryModel;
use App\Models\CategoryFeatureModel;
use App\Models\ProductModel;
use Illuminate\Http\Request;

class Store extends Controller
{

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
}
