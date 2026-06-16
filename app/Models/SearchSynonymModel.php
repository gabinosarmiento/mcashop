<?php

namespace App\Models;

use App\Models\BaseModel;

class SearchSynonymModel extends BaseModel
{
    /**
     * The name of the "created at" column.
     *
     * @var string
     */
    const UPDATED_AT = null;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'search_synonym';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['term', 'synonym'];
}