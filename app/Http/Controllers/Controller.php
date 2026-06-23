<?php

namespace App\Http\Controllers;

use App\Models\CategoryModel;
use App\Services\SearchService;
use Illuminate\Http\Request;

abstract class Controller
{
    protected function menu_categories()
    {
        $items      = [];
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

                    if ($category->menu == 1) {
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

    public function search(Request $request, SearchService $service)
    {
        $data = $service->searchQuery($request);

        if ($request->has('partial')) {
            return view('partials.dofinderitem', compact('data'));
        }

        return view('partials.dofinder', compact('data'));
    }
}