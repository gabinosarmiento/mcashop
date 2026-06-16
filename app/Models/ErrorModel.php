<?php

namespace App\Models;

use App\Models\BaseModel;

class ErrorModel extends BaseModel
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'error';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['tag', 'reference', 'exception'];
}
