<?php

namespace App\Models;

class ProductSearchModel extends BaseModel
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'product_search';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['product_id', 'sku', 'name', 'subname', 'description', 'features'];

    /**
     * Get the product that owns the search record.
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(ProductModel::class);
    }

    /**
     * Get the search attributes.
     */
    public function attributes(): HasMany
    {
        return $this->hasMany(SearchAttributeModel::class, 'search_id');
    }
}
