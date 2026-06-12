<?php

namespace App\Models;

use App\Models\BaseModel;

class CarrierZoneModel extends BaseModel
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
    protected $table = 'carrier_zone';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['carrier_id', 'origin', 'destiny', 'zone'];
}
