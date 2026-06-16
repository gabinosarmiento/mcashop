<?php

namespace App\Models;

use App\Models\BaseModel;

class SearchBlacklistModel extends BaseModel
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
    protected $table = 'search_blacklist';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['word'];
}