<?php

namespace App\Models;

use App\Models\BaseModel;

class MarkupModel extends BaseModel
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'up_markup';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['base', 'bound', 'markup'];
}
