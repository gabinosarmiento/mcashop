<?php

namespace App\Models;

use App\Models\BaseModel;

class StateModel extends BaseModel
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
    protected $table = 'state';

    /**
     * Get the cities associated with the state.
     */
    public function cities()
    {
        return $this->hasMany('App\Models\CityModel', 'state_id');
    }
}