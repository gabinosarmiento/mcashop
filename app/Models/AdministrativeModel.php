<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;

class AdministrativeModel extends Authenticatable
{
    use Notifiable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'administrative';

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = ['name'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = ['password', 'remember_token'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['firstname', 'lastname', 'department', 'email', 'password', 'image', 'status'];

    /**
     * Get the administrative's full name.
     */
    public function getNameAttribute()
    {
        return "{$this->firstname} {$this->lastname}";
    }

    /**
     * Set the administrative's password.
     */
    public function setPasswordAttribute($value)
    {
        if (isset($value)) {
            $this->attributes['password'] = Hash::make($value);
        }
    }

    /**
     * Set the administrative's email.
     */
    public function setEmailAttribute($value)
    {
        if (isset($value)) {
            $this->attributes['email'] = strtolower($value);
        }
    }

    /**
     * Get the modules that belong to the administrative.
     */
    public function modules()
    {
        return $this->hasMany(AdministrativeModuleModel::class, 'administrative_id');
    }
}
