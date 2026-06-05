<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\CategoryModel;
use App\Models\ProductModel;
use App\Services\SearchService;
use Illuminate\Http\Request;

class Site extends Controller
{
    public function search(Request $request)
    {
        $data = app(SearchService::class)->searchQuery($request);

        if ($request->has('partial')) {
            return view('partials.doinner', compact('data'));
        }

        return view('partials.dofinder', compact('data'));
    }

    public function index()
    {
        $data['menu'] = $this->menu_categories();

        $data['devices']    = ProductModel::with('brand', 'inventory')->has('inventory')->hasWhere('category', ['parent_id', 151])->where('status', 'Activo')->orderByDesc('created_at')->limit(100)->get()->random(6)->toArray();
        $data['printers']   = ProductModel::with('brand', 'inventory')->has('inventory')->hasWhere('category', ['parent_id', 1239])->where('status', 'Activo')->orderByDesc('created_at')->limit(100)->get()->random(6)->toArray();
        $data['computers']  = ProductModel::with('brand', 'inventory')->has('inventory')->hasWhere('category', ['parent_id', 114])->where('status', 'Activo')->orderByDesc('created_at')->limit(100)->get()->random(6)->toArray();
        $data['categories'] = CategoryModel::has('products.inventory')->where('status', 'Activo')->where('popular', 1)->inRandomOrder()->limit(10)->get()->toArray();

        return view('site.index', compact('data'));
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

                    if ($category->node == 1) {
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
