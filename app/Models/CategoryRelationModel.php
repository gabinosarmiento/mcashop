<?php

namespace App\Models;

use App\Models\BaseModel;

class CategoryRelationModel extends BaseModel
{
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'category_relation';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['category_id', 'relation_id'];

    /**
     * Get the proveedor taxonomies that owns the sku_terminos.
     */
    public function category()
    {
        return $this->belongsTo('App\Models\CategoryModel', 'relation_id');
    }
}