<?php

namespace App\Models;

use App\Models\BaseModel;
use App\Models\CategoryFeatureModel;
use App\Models\CategoryRelationModel;
use App\Models\CategoryVariantModel;
use App\Models\ProductModel;

class CategoryModel extends BaseModel
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'category';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['parent_id', 'name', 'subname', 'node', 'menu', 'verified', 'status'];

    /**
     * Get the parent associated with the category.
     */
    public function parent()
    {
        return $this->belongsTo(CategoryModel::class, 'parent_id');
    }

    /**
     * Get the children associated with the category.
     */
    public function children()
    {
        return $this->hasMany(CategoryModel::class, 'parent_id');
    }

    /**
     * Get the variants associated with the category.
     */
    public function variants()
    {
        return $this->hasMany(CategoryVariantModel::class, 'category_id');
    }

    /**
     * Get the categories related with the category.
     */
    public function relations()
    {
        return $this->hasMany(CategoryRelationModel::class, 'category_id');
    }

    /**
     * Get the features associated with the category.
     */
    public function features()
    {
        return $this->hasMany(CategoryFeatureModel::class, 'category_id');
    }

    /**
     * Get the products related with the category.
     */
    public function products()
    {
        return $this->hasMany(ProductModel::class, 'category_id');
    }
}
