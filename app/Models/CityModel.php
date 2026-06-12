<?php

namespace App\Models;

use App\Models\BaseModel;

class CityModel extends BaseModel
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
    protected $table = 'city';

    /**
     * Get the state associated to this municipality.
     */
    public function state()
    {
        return $this->belongsTo('App\Models\StateModel', 'state_id');
    }

    /**
     * Get the municipality associated with the state.
     */
    public function colonies()
    {
        return $this->hasMany('App\Models\ColonyModel', 'city_id');
    }
}
