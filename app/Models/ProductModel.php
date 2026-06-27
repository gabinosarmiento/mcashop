<?php

namespace App\Models;

use App\Models\BaseModel;
use App\Models\BrandModel;
use App\Models\CategoryModel;
use App\Models\InventoryIndexModel;
use App\Models\ProductDocumentModel;
use App\Models\ProductDuplicateModel;
use App\Models\ProductFeatureModel;
use App\Models\ProductImageModel;
use App\Models\ProductRelationModel;
use App\Models\ProductSearchModel;

class ProductModel extends BaseModel
{
   /**
    * The table associated with the model.
    *
    * @var string
    */
   protected $table = 'product';

   /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
   protected $fillable = ['id', 'brand_id', 'category_id', 'sku', 'core', 'gtin', 'weight', 'name', 'subname', 'description', 'review', 'image', 'note', 'missing', 'dimension', 'icecat', 'search', 'health', 'checked', 'status'];

   /**
    * Get the brand associated with the product.
    */
   public function brand()
   {
      return $this->belongsTo(BrandModel::class, 'brand_id');
   }

   /**
    * Get the category associated with the product.
    */
   public function category()
   {
      return $this->belongsTo(CategoryModel::class, 'category_id');
   }

   /**
    * Get the product features records associated with the product.
    */
   public function features()
   {
      return $this->hasMany(ProductFeatureModel::class, 'product_id');
   }

   /**
    * Get the images records associated with the product.
    */
   public function images()
   {
      return $this->hasMany(ProductImageModel::class, 'product_id');
   }

   /**
    * Get the records where the product is the main (product_id).
    */
   public function products()
   {
      return $this->hasMany(ProductDuplicateModel::class, 'product_id');
   }

   /**
    * Get the records where the product is the duplicate (duplicate_id).
    */
   public function duplicates()
   {
      return $this->hasMany(ProductDuplicateModel::class, 'duplicate_id');
   }

   /**
    * Get the relations records associated with the product.
    */
   public function relations()
   {
      return $this->hasMany(ProductRelationModel::class, 'product_id');
   }

   /**
    * Get the search record associated with the product.
    */
   public function search()
   {
      return $this->hasOne(ProductSearchModel::class, 'product_id');
   }

   /**
    * Get the best inventory of the day.
    */
   public function inventory()
   {
      return $this->hasOne(InventoryIndexModel::class, 'product_id');
   }
}