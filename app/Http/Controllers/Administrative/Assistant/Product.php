<?php

namespace App\Http\Controllers\Administrative\Assistant;

use App\Http\Controllers\Administrative\Assistant;
use App\Http\Requests\Administrative\ProductRequest;
use App\Http\Requests\Administrative\SearchRequest;
use App\Models\BrandModel;
use App\Models\CategoryModel;
use App\Models\ProductModel;
use Illuminate\Http\Request;

class Product extends Assistant
{
    /**
     * Number of records displayed per page.
     *
     * @var int
     */
    protected $page = 15;

    public function index()
    {
        $data = ProductModel::orderByDesc('id')->paginate($this->page)->toArray();

        return view('administrative.assistant.product.index', compact('data'));
    }
    public function see(Request $request)
    {
    	$product = ProductModel::with('brand', 'images', 'search.attributes', 'relations.supplier', 'features.feature', 'features.attributes.attribute', 'category.features.attributes')->find($request->id);

        $features = $product->features->sortBy('feature.name');

    	$data = $product->setRelation('features', $features)->toArray();

    	$update = view('administrative.assistant.product.see', compact('data'));

    	return response(['update' => ['overapp' => $update->render()]]);
    }

    public function add()
    {
        $update = view('administrative.assistant.product.add');

        return response(['update' => ['overapp' => $update->render()]]);
    }

    public function edit(Request $request)
   {
      $data = ProductModel::with('brand', 'category')->find($request->id)->toArray();

      $update = view('administrative.assistant.product.edit', compact('data'));

      return response(['update' => ['overapp' => $update->render()]]);
   }

    public function save(ProductRequest $request)
    {
        $data = $request->only('sku', 'brand_id', 'category_id', 'name', 'subname', 'weight', 'gtin', 'description', 'review', 'note', 'status');

        ProductModel::create($data);

        return $this->records($request);
    }

    public function update(ProductRequest $request)
    {
    	$data = $request->only('sku', 'brand_id', 'category_id', 'name', 'subname', 'weight', 'gtin', 'description', 'review', 'note', 'status');

    	ProductModel::find($request->id)->update($data);

    	return $this->records($request);
    }



    public function brands(SearchRequest $request)
    {
        $data = BrandModel::where('name', 'like', "%{$request->search}%")->orderBy('name')->get();

        return $data->toArray();
    }

    public function categories(SearchRequest $request)
    {
        $data = CategoryModel::whereDoesntHave('children')->whereRaw("concat_ws(' ', name, subname) like ?", ["%{$request->search}%"])->orderBy('name')->get();

        return $data->toArray();
    }

    public function records(Request $request)
    {
        do {
            $query = ProductModel::query()->orderByDesc('id');

            if ($request->search) {
                $query->whereRaw('concat_ws(" ", id, sku, name) like ?', ["%{$request->search}%"])->orderByRaw('sku, name');
            }

            $records = $query->paginate($this->page, ['*'], 'page', $request->page);
        } while ($records->count() == 0 && --$request->page);

        $data = $records->toArray();

        $update = view('administrative.assistant.product.records', compact('data'));

        return response(['update' => ['records' => $update->render()]]);
    }
}
