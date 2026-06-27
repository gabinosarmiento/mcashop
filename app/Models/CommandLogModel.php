<?php

namespace App\Models;

class CommandLogModel extends BaseModel
{
    /**
     * Indicates if the model should be timestamped.
     *
     * @var string|null
     */
    const UPDATED_AT = null;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'command_log';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['command_id', 'type', 'message', 'context'];
}
