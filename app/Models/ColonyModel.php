<?php

namespace App\Models;

use App\Models\BaseModel;

class ColonyModel extends BaseModel
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
    protected $table = 'colony';

    /**
     * Get the municipality associated to this colony.
     */
    public function city()
    {
        return $this->belongsTo('App\Models\CityModel', 'city_id');
    }
}
