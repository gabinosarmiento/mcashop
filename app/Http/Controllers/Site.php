<?php

namespace App\Http\Controllers;

use App\Models\CategoryModel;
use App\Models\ProductModel;

class Site extends Controller
{
    public function index()
    {
        $data['menu'] = $this->menu_categories();

        $data['devices']    = ProductModel::with('brand', 'inventory')->has('inventory')->hasWhere('category', ['parent_id', 151])->where('status', 'Activo')->orderByDesc('created_at')->limit(100)->get()->random(6)->toArray();
        $data['printers']   = ProductModel::with('brand', 'inventory')->has('inventory')->hasWhere('category', ['parent_id', 1239])->where('status', 'Activo')->orderByDesc('created_at')->limit(100)->get()->random(6)->toArray();
        $data['computers']  = ProductModel::with('brand', 'inventory')->has('inventory')->hasWhere('category', ['parent_id', 114])->where('status', 'Activo')->orderByDesc('created_at')->limit(100)->get()->random(6)->toArray();
        $data['categories'] = CategoryModel::has('products.inventory')->where('status', 'Activo')->where('popular', 1)->inRandomOrder()->limit(10)->get()->toArray();

        return view('site.index', compact('data'));
    }
}