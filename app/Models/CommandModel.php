<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;

class CommandModel extends BaseModel
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
     */protected $table = 'command';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['name', 'label', 'description', 'progress', 'duration', 'total', 'errors', 'note', 'heartbeat', 'status', 'finished_at'];

    /**
     * Get the log entries associated with the command.
     */
    public function logs(): HasMany
    {
        return $this->hasMany(CommandLogModel::class, 'command_id');
    }
}
