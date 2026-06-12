<?php

namespace App\Models;

use App\Models\BaseModel;

class CarrierRateModel extends BaseModel
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
    protected $table = 'carrier_rate';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['carrier_id', 'zone', 'weight', 'price'];

    /**
     * Get the carrier associated to this record.
     */
    public function carrier()
    {
        return $this->belongsTo('App\Models\CarrierModel', 'carrier_id');
    }
}