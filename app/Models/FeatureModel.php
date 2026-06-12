<?php

namespace App\Models;

use App\Models\BaseModel;

class FeatureModel extends BaseModel
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
    protected $table = 'feature';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['icecat', 'name'];
}